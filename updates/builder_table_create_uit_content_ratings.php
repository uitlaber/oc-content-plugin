<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentRatings extends Migration
{
    public function up()
    {
        Schema::create('uit_content_ratings', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ratingable_id')->unsigned();
            $table->string('ratingable_type');
            $table->integer('rating')->nullable();
            $table->string('ip')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_ratings');
    }
}
