<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentTaggables extends Migration
{
    public function up()
    {
        Schema::create('uit_content_taggables', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tag_id');
            $table->integer('taggable_id');
            $table->string('taggable_type');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_taggables');
    }
}
