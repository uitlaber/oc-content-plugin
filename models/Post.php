<?php namespace Uit\Content\Models;

use Model;
use October\Rain\Database\Traits\Sluggable;
use Uit\Lazyshop\Models\Product;

/**
 * Model
 */
class Post extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use Sluggable;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_posts';

    protected $jsonable = ['images'];

    public $implement = ['@Renatio.SeoManager.Behaviors.SeoModel'];

    protected $slugs = ['slug' => 'name'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $morphToMany = [
        'tags' => [Tag::class, 'name' => 'taggable', 'table' => 'uit_content_taggables'],

    ];

    public $morphMany = [
        'ratings' => [Rating::class, 'name' => 'ratingable' ],
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];



    public function rateIt($rating)
    {
        $ip = request()->ip();

        $this->ratings()->create([
            'ip' => request()->ip(),
            'rating' => $rating
        ]);
    }


    public function rating()
    {
        $rate = 0;
        if($this->ratings()->count()) {
            $ratings = $this->ratings()->get();
            foreach ($ratings as $rating) {
                $rate = $rate + $rating->rating;
            }
            return $rate / $this->ratings()->count();
        }
        return 0;
    }

    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }


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
