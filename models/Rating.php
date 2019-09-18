<?php namespace Uit\Content\Models;

use Model;

/**
 * Model
 */
class Rating extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_ratings';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    protected $fillable = [
        'rating',
        'ip'
    ];

    public $morphTo = [
        'ratingable' => []
    ];

}
