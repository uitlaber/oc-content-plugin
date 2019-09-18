<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentPostProducts extends Migration
{
    public function up()
    {
        Schema::create('uit_content_post_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->integer('product_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_post_products');
    }
}
