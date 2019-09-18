<?php namespace Uit\Content\Components;

use Cms\Classes\ComponentBase;
use Cookie;
use Flash;
use Mail;
use RainLab\User\Models\User;
use Uit\Content\Models\Page;
use Uit\Content\Models\Post;
use Uit\Content\Models\Review;
use Uit\Content\Models\Faq;
use Uit\Content\Models\Subscribe;
use Uit\Content\Models\SubscribeType;
use Uit\Lazyshop\Models\Category;
use Uit\Lazyshop\Models\Settings;
use RainLab\User\Facades\Auth;
use Uit\Userextend\Models\UserFields;
use Validator;
use ValidationException;


class ContentTools extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'ContentTools Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['currentCity'] = $currentCity = $this->getCurrentCity();
        $this->page['contacts'] = array_shift($currentCity['contacts']);
    }

    public function getPages($type, $limit = 10)
    {
        return Page::published()->byType($type)->take($limit)->orderBy('created_at', 'desc')->get();
    }

    public function getPosts($limit = 10)
    {
        return Post::published()->take($limit)->orderBy('created_at', 'desc')->get();
    }

    public function getVideos($limit)
    {
        return \Uit\Content\Models\Video::published()->take($limit)->orderBy('created_at', 'desc')->get();
    }

    public function getOverviews()
    {
        return $this->getPages(4, 50);
    }

    public function getCities()
    {
        $setting = Settings::instance();
        return $setting->regions;
    }

    public function getLastPublications($limit = 3)
    {
        return Page::published()->take($limit)->whereHas('type', function ($q) {
            $q->where('has_page', true);
        })->orderBy('created_at', 'desc')->get();
    }

    public function getCurrentCity()
    {
        $cities = $this->getCities();
        if (Cookie::has('city')) {
            foreach ($cities as $city) {
                if ($city['name'] == Cookie::get('city')) {
                    return $city;
                }
            }
        } else {
            return array_shift($cities);
        }
    }

    public function onChangeCity()
    {
        $cities = $this->getCities();
        $currentCity = null;
        foreach ($cities as $city) {
            if ($city['name'] == post('city')) {
                Cookie::queue('city', $city['name'], time() + (10 * 365 * 24 * 60 * 60));
                $currentCity = $city;
            }
        }
        if (is_null($currentCity)) return;
        $contacts = array_shift($currentCity['contacts']);
        return redirect()->back();
//        return [
//            '.js-city-name' => $currentCity['name'],
//            '.js-city-phone' => (array_key_exists('phone', $contacts)) ? $contacts['phone'] : '',
//            '.js-city-email' => (array_key_exists('email', $contacts)) ? $contacts['email'] : '',
//            '.js-city-address' => (array_key_exists('address', $contacts)) ? $contacts['address'] : '',
//            '.js-city-time' => (array_key_exists('time', $contacts)) ? $contacts['time'] : '',
//        ];
    }

    public function getReviews($limit)
    {
        return Review::published()->take($limit)->orderBy('created_at', 'desc')->get();
    }

    public function loadSubscribeTypes()
    {
        return SubscribeType::all();
    }

    public function onSubscribe()
    {
        $email = post('email');
        if (is_null($email)) {
            return;
        }
        $exists = Subscribe::where('email', $email)->exists();
        if ($exists) {
            Flash::success('Вы уже подписаны');
            return;
        }

        $subscribe = new Subscribe();
        $subscribe->email = $email;
        $subscribe->save();
        $type_ids = SubscribeType::pluck('id');
        $subscribe->types()->attach($type_ids);
        $popup_id = str_random(6);
        $popup_content = 'Спасибо за подписку!';
        return [
            'success' => 1,
            '#scripts' => $this->renderPartial('@_popup', compact('popup_content', 'popup_id'))
        ];

    }

    public function onSubscribeChange()
    {
        $user = Auth::getUser();
        if (is_null($user)) {
            Flash::error('Нужно авторизоваться');
            return redirect()->to('login');
        }
        $types = post('types');

        if (is_null($types)) {
            $user->subscribe->types()->detach();
            Flash::success('Данные сохранены');
            return;
        }
        foreach ($types as $key => $type) {
            $exists = SubscribeType::where('id', $type)->exists();
            if (!$exists) {
                unset($types[$key]);
            }
        }

        if (is_null($user->subscribe)) {
            $subscribe = new Subscribe();
            $subscribe->email = $user->email;
            $subscribe->user_id = $user->id;
            $subscribe->save();
        }
        if(is_null($user->subscribe->types)){
            $user->subscribe->types()->attach($types);
        }else{
            $user->subscribe->types()->sync($types);
        }

        Flash::success('Данные сохранены');
        return ['success' => 1];
    }


    public function onQuestion()
    {
        $data = post();
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'question' => 'required',
        ];
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
        $faq = new Faq();
        $faq->question_name = $data['name'];
        $faq->question_email = $data['email'];
        $faq->question = $data['question'];
        $faq->product_id = isset($data['product_id']) ? $data['product_id'] : null;
        $faq->save();

        $popup_id = str_random(6);
        $popup_content = 'Спасибо! Ваш вопрос принят.';
        return [
            'success' => 1,
            '#scripts' => $this->renderPartial('@_popup', compact('popup_content', 'popup_id'))

        ];
    }

    public function otherPosts($id, $limit = 3)
    {
        return Post::where('id', '!=', $id)->take($limit)->orderBy('created_at', 'desc')->get();
    }

    public function otherPages($id, $limit = 3)
    {
        $page = Page::find($id);
        return Page::where('id', '!=', $id)->where('type_id',$page->type_id)->take($limit)->orderBy('created_at', 'desc')->get();
    }


    public function onRatePost()
    {

        $data = post();
        $ip = request()->ip();

        if (is_numeric($data['rating']) && $data['rating'] <= 5 && $data['rating'] >= 1) {
            $post = Post::find($data['id']);

            $exists = $post->ratings()->where('ip', $ip)->exists();

            if ($exists) {
                return;
            }

            $post->rateIt($data['rating']);
            Flash::success('Спасибо за оценку!');
            return [
                '#scripts' => '<script>$(\'.content-rating form\').addClass(\'rated\')</script>'
            ];
        }


    }

    public function isRated($post)
    {
        $ip = request()->ip();
        return $post->ratings()->where('ip', $ip)->exists();
    }

    public function onRatePage()
    {

        $data = post();
        $ip = request()->ip();

        if (is_numeric($data['rating']) && $data['rating'] <= 5 && $data['rating'] >= 1) {
            $post = Page::find($data['id']);

            $exists = $post->ratings()->where('ip', $ip)->exists();

            if ($exists) {
                return;
            }

            $post->rateIt($data['rating']);
            Flash::success('Спасибо за оценку!');
            return [
                '#scripts' => '<script>$(\'.content-rating form\').addClass(\'rated\')</script>'
            ];
        }


    }


}
