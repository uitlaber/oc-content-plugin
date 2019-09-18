<?php namespace Uit\Content\Models;

use Model;

/**
 * Model
 */
class PageType extends Model
{
    use \October\Rain\Database\Traits\Validation;
    public $implement = ['@Renatio.SeoManager.Behaviors.SeoModel'];
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_types';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
