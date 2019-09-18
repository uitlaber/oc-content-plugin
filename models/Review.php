<?php namespace Uit\Content\Models;

use Model;
use RainLab\User\Models\User;

/**
 * Model
 */
class Review extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_reviews';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];



    public $morphTo = [
        'revieweable' => []
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
