<?php namespace Uit\Content\Models;

use Model;
use RainLab\User\Models\User;

/**
 * Model
 */
class Subscribe extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_subscribes';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public  $belongsToMany = [
        'types' => [SubscribeType::class, 'table' => 'uit_content_subscribes_types', 'otherKey' => 'type_id']
        ];

    public $belongsTo = [
        'user' => User::class
    ];
}
