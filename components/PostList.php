<?php namespace Uit\Content\Components;

use Cms\Classes\ComponentBase;
use Uit\Content\Models\Tag;

class PostList extends ComponentBase
{

    public $posts;
    public $tags;

    public function componentDetails()
    {
        return [
            'name'        => 'PostList Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->posts = $this->loadPosts();
        $this->tags = $this->loadTags();
    }

    public function loadTags()
    {
        return Tag::whereHas('posts')->get();
    }


    public function loadPosts($limit = 4)
    {
        if (get('keyword')) {
            $query =  \Uit\Content\Models\Post::published()->search(get('keyword'));
        }elseif (get('tag')) {
            $query = \Uit\Content\Models\Post::published()->withTag(get('tag'));
        } else {
            $query = \Uit\Content\Models\Post::published();
        }
        return $query->orderBy('created_at','desc')->paginate($limit);
    }

    public function onLoadMore()
    {
        $currentPage = post('currentPage', 1) + 1;

        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });


        $posts = $this->loadPosts();


        return [
            'results' => $this->renderPartial('@_posts', compact('posts')),
            'currentPage' => $currentPage,
            '#pagination' => $this->renderPartial('@_loadmore', [
                'results' => $posts,
                'wrapper' => '#pagination',
                'keyword' => get('keyword'),
                'tag' => get('tag'),
            ])
        ];
    }
}
