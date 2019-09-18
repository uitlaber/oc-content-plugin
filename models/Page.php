<?php namespace Uit\Content\Models;

use Model;
use October\Rain\Database\Traits\Sluggable;
use Uit\Lazyshop\Models\Product;

/**
 * Model
 */
class Page extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use Sluggable;

    protected $jsonable = ['images'];

    protected $slugs = ['slug' => 'name'];

    public $implement = ['@Renatio.SeoManager.Behaviors.SeoModel', 'RainLab.Translate.Behaviors.TranslatableModel'];


    public $translatable = ['name', 'content'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_pages';

    /**
     * @var array Validation rules
     */


    public $morphMany = [
        'reviews' => [Review::class, 'name' => 'revieweable'],
        'ratings' => [Rating::class, 'name' => 'ratingable' ],
    ];

    public $belongsTo = [
        'type' => PageType::class,
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];

    public $morphToMany = [
        'tags' => [Tag::class, 'name' => 'taggable', 'table' => 'uit_content_taggables'],
        'ratings' => [Rating::class, 'name' => 'ratingable'],
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



    public function getCategory()
    {
        $product = $this->products()->first();
        if(is_null($product)) return;
        return $product->category;
    }


    public function getTypeOptions()
    {
        return PageType::pluck('name','id')->toArray();
    }


    public $rules = [
    ];

    public function scopeIsOverview($query)
    {
        return $query->where('type_id', 4);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type_id', $type);
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


    public function scopeDynamic($query)
    {
        return $query->whereHas('type', function ($q){
            $q->where('has_page', true);
        });
    }

    public function scopeStatic($query)
    {
        return $query->whereHas('type', function ($q){
            $q->where('has_page', false);
        });
    }



}
