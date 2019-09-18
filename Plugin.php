<?php namespace Uit\Content;

use RainLab\User\Models\User;
use System\Classes\PluginBase;
use Uit\Content\Models\Page;
use Uit\Content\Models\PageType;
use Uit\Content\Models\Post;
use Uit\Content\Models\Subscribe;


class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            '\Uit\Content\Components\ContentTools' => 'contentTools',
            '\Uit\Content\Components\Video' => 'video',
            '\Uit\Content\Components\PageType' => 'pageType',
            '\Uit\Content\Components\Page' => 'pageSingle',
            '\Uit\Content\Components\PostList' => 'postList',
            '\Uit\Content\Components\Post' => 'postSingle',
            '\Uit\Content\Components\StaticPage' => 'staticPage',
            '\Uit\Content\Components\ResetPassword' => 'reset',
            '\Uit\Content\Components\Jobs' => 'ourJobs',
        ];
    }

    public function registerSettings()
    {
    }


    public function registerMarkupTags()
    {
        return [
            'filters' => [
                // A global function, i.e str_plural()
                'phone' => [$this, 'renderPhone'],
                'email' => [$this, 'renderEmail'],
            ],
            'functions' => [
                'plural' => [$this, 'plural_form'],
                'page_url' => [$this, 'pageUrl'],
                'post_url' => [$this, 'postUrl'],
                'blog_url' => [$this, 'blogUrl'],
                'page_type_url' => [$this, 'pageTypeUrl'],
                'text_cut' => [$this, 'textCut'],
            ]
        ];
    }


    public function plural_form($number, $after)
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        echo $number . ' ' . $after[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }


    public function boot()
    {
        User::extend(function ($model) {
            $model->hasOne['subscribe'] = Subscribe::class;
            $model->addDynamicMethod('hasSubscribe', function ($id) use ($model) {
                if(is_null($model->subscribe)) return false;
                return $model->subscribe->types()->where('type_id', $id)->exists();
            });
        });
    }


    public function textCut($string, $limit = 100)
    {
        $string = strip_tags($string);
        if (strlen($string) > $limit) {

            // truncate string
            $stringCut = substr($string, 0, $limit);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';
        }
        echo $string;
    }

    public function renderPhone($phone, $attr = null)
    {
        $cleared = str_replace(['(', ')', '-'], '', $phone);
        return '<a href="tel:' . $cleared . '">' . $phone . '</a>';
    }

    public function renderEmail($email, $attr = null)
    {
        return '<a href="mailto:' . $email . '">' . $email . '</a>';
    }

    public function pageTypeUrl($type)
    {
        $needleType = null;
        if (is_numeric($type)) {
            $needleType = PageType::findOrFail($type);
        } else {
            $needleType = PageType::bySlug($type)->first();
        }
        if (is_null($needleType)) return;
        $cmsPage = $this->findPage('pageType');
        $type = [
            'type' => $needleType->slug
        ];
        $url = str_replace(':', '', $cmsPage->url);
        return url(str_replace(array_keys($type), $type, $url));
    }

    public function blogUrl()
    {
        $cmsPage = $this->findPage('postList');
        $url = str_replace(':', '', $cmsPage->url);
        return url($url);
    }

    public function postUrl($post)
    {
        if(is_numeric($post)){
            $post = Post::find($post);
        }elseif (is_string($post)){
            $post = Post::bySlug($post)->first();
        }
        if(is_null($post)) return;

        $cmsPage = $this->findPage('postSingle');
        $type = [
            'slug' => $post->slug
        ];
        $url = str_replace(':', '', $cmsPage->url);
        return url(str_replace(array_keys($type), $type, $url));
    }

    public function pageUrl($page)
    {
        if(is_numeric($page)){
            $page = Page::find($page);
        }elseif (is_string($page)){
            $page = Page::bySlug($page)->first();
        }

        if(is_null($page)) return;

        if($page->type->has_page) {
            $component = 'pageSingle';
        }else {
            $component = 'staticPage';
        }
        $cmsPage = $this->findPage($component);

        $type = [
            'type' => $page->type->slug,
            'slug' => $page->slug
        ];

        $url = str_replace(':', '', $cmsPage->url);
        return url(str_replace(array_keys($type), $type, $url));
    }


    public function findPage($componentName)
    {
        $currentTheme = \Cms\Classes\Theme::getEditTheme();
        $allPages = \Cms\Classes\Page::listInTheme($currentTheme, true);
        $needlePage = null;
        foreach ($allPages as $page) {
            foreach ($page->settings['components'] as $key => $component) {
                if (strpos($key, $componentName) !== false) {
                    $needlePage = $page;
                    continue;
                }
            }
        }
        return $needlePage;
    }
}
