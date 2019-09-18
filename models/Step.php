<?php namespace Uit\Content\Models;

use Model;
use October\Rain\Database\Traits\Sortable;

/**
 * Model
 */
class Step extends Model
{
    use \October\Rain\Database\Traits\Validation, Sortable;
    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['name', 'content'];
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_steps';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
      'image' => 'System\Models\File'
    ];
}
