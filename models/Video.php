<?php namespace Uit\Content\Models;

use Model;

/**
 * Model
 */
class Video extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_videos';

    protected $jsonable = ['images'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $morphToMany = [
        'tags' => [Tag::class, 'name' => 'taggable', 'table' => 'uit_content_taggables']
    ];


    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('name','like', '%'.$keyword.'%')->orWhere('content','like','%'.$keyword.'%');
    }

    public function scopeWithTag($query, $tag)
    {
        return $query->whereHas('tags', function ($q) use ($tag){
            $q->where('name', $tag);
        });
    }
}
