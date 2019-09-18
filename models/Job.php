<?php namespace Uit\Content\Models;

use Model;

/**
 * Model
 */
class Job extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_jobs';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
