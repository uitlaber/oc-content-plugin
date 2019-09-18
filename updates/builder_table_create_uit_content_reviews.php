<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentReviews extends Migration
{
    public function up()
    {
        Schema::create('uit_content_reviews', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('content');
            $table->integer('rating')->nullable();
            $table->integer('order')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_reviews');
    }
}
