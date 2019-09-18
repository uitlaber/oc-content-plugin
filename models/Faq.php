<?php namespace Uit\Content\Models;

use Model;
use Uit\Lazyshop\Models\Product;

/**
 * Model
 */
class Faq extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'uit_content_faqs';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'product' => Product::class
    ];
}
