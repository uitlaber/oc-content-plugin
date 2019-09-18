<?php namespace Uit\Content\Components;

use Cms\Classes\ComponentBase;

class StaticPage extends ComponentBase
{

    public $currentPage;

    public function componentDetails()
    {
        return [
            'name' => 'Статическая страница',
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
        if (is_null($this->currentPage)) return $this->notFound();
        $this->setDefaultMeta();
    }

    public function notFound()
    {
        $this->setStatusCode(404);
        return $this->controller->run('404');
    }

    public function setDefaultMeta()
    {
        if (!is_null($this->currentPage->seo_tag) && is_null($this->currentPage->seo_tag->meta_title)
            || !is_null($this->currentPage->seo_tag) && empty($this->currentPage->seo_tag->meta_title)) {
            $this->currentPage->seo_tag->meta_title = $this->currentPage->name;
            $this->currentPage->seo_tag->save();
        }
    }

    public function loadPage($slug)
    {
        return \Uit\Content\Models\Page::static()->bySlug($slug)->first();
    }
}
