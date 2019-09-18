<?php namespace Uit\Content\Components;

use Cms\Classes\ComponentBase;
use Uit\Content\Models\Tag;

class PageType extends ComponentBase
{

    public $type;
    public $pages;
    public $tags;

    public function componentDetails()
    {
        return [
            'name' => 'PageType Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->type = $this->page['pageType'] =  $this->loadPageType($this->param('type'));
        if(is_null($this->type)) return $this->notFound();
        $this->page['page_type'] = $this->type;
        session()->put('page_type', $this->type->id);
        session()->put('page_type_slug', $this->type->slug);
        $this->pages = $this->loadPages($this->type->id);
        $this->tags = $this->loadTags($this->type->id);
    }

    public function loadPageType($slug)
    {
        return \Uit\Content\Models\PageType::bySlug($slug)->first();
    }

    public function notFound()
    {
        $this->setStatusCode(404);
        return $this->controller->run('404');
    }

    public function loadTags($type_id)
    {
        return Tag::whereHas('pages', function ($q) use ($type_id){
            $q->where('type_id', $type_id);
        })->get();
    }


    public function loadPages($type, $limit = 5)
    {
        $query =  \Uit\Content\Models\Page::published()->byType($type);
        if (get('keyword')) {
            $query =  $query->search(get('keyword'));
        }elseif (get('tag')) {
            $query = $query->withTag(get('tag'));
        }
        return $query->orderBy('created_at','desc')->paginate($limit);
    }

    public function onLoadMore()
    {
        $currentPage = post('currentPage', 1) + 1;

        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });


        $pages = $this->loadPages(session('page_type'));

        $type = $this->loadPageType(session('page_type_slug'));

        $partial = '@_pages';
        if($type->slug == 'expert' || $type->slug == 'cases'){
            $partial = '@_pages-expert';
        }
        return [
            'results' => $this->renderPartial($partial, compact('pages', 'type')),
            'currentPage' => $currentPage,
            '#pagination' => $this->renderPartial('@_loadmore', [
                'results' => $pages,
                'wrapper' => '#pagination',
                'keyword' => get('keyword'),
                'tag' => get('tag'),
            ])
        ];
    }
}
