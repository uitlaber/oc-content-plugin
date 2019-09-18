<?php namespace Uit\Content\Components;

use Cms\Classes\ComponentBase;

class Page extends ComponentBase
{

    public $currentPage;
    
    public function componentDetails()
    {
        return [
            'name'        => 'Page Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['currentPage'] = $this->currentPage = $this->loadPage($this->param('slug'));
        if(is_null($this->currentPage)) return $this->notFound();
        $this->setDefaultMeta();
    }

    public function notFound()
    {
        $this->setStatusCode(404);
        return $this->controller->run('404');
    }


    public function loadPage($slug){
        return \Uit\Content\Models\Page::dynamic()->bySlug($slug)->first();
    }

    public function setDefaultMeta()
    {
        if (!is_null($this->currentPage->seo_tag) && is_null($this->currentPage->seo_tag->meta_title)
            || !is_null($this->currentPage->seo_tag) && empty($this->currentPage->seo_tag->meta_title)) {
            $this->currentPage->seo_tag->meta_title = $this->currentPage->name;
            $this->currentPage->seo_tag->save();
        }
    }
}
