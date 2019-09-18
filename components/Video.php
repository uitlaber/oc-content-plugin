<?php namespace Uit\Content\Components;

use Cms\Classes\ComponentBase;
use Uit\Content\Models\Tag;

class Video extends ComponentBase
{
    public $videos;
    public $tags;

    public function componentDetails()
    {
        return [
            'name'        => 'Video Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->videos = $this->loadVideos();
        $this->tags = $this->loadTags();
        if (is_null($this->videos)) return $this->notFound();

    }

    public function notFound()
    {
        $this->setStatusCode(404);
        return $this->controller->run('404');
    }

    public function loadTags()
    {
        return Tag::whereHas('videos', function ($q){
            $q->where('published', true);
        })->get();
    }


    public function loadVideos()
    {
        if(get('keyword')){
            return \Uit\Content\Models\Video::published()->search(get('keyword'))->paginate(4);
        }if(get('tag')){
            return \Uit\Content\Models\Video::published()->withTag(get('tag'))->paginate(4);
        }else{
            return \Uit\Content\Models\Video::published()->paginate(4);
        }
    }

    public function onLoadMore()
    {
        $currentPage = post('currentPage', 1) + 1;

        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $videos = $this->loadVideos();

        return [
            'results' => $this->renderPartial('@_videos', compact('videos')),
            'currentPage' => $currentPage,
            '#pagination' => $this->renderPartial('@_loadmore', [
                'results' => $videos,
                'wrapper' => '#pagination',
                'keyword' => get('keyword'),
                'tag' => get('tag'),
            ])
        ];
    }


}
