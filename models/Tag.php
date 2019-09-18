<?php namespace Uit\Content\Models;

use Model;

/**
 * Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $fillable = ['name'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_tags';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $morphedByMany = [
        'pages'  => [Page::class, 'name' => 'taggable', 'table' => 'uit_content_taggables'],
        'posts'  => [Post::class, 'name' => 'taggable', 'table' => 'uit_content_taggables'],
        'videos' => [Video::class, 'name' => 'taggable', 'table' => 'uit_content_taggables']
    ];
}
