<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentSubscribeTypes extends Migration
{
    public function up()
    {
        Schema::create('uit_content_subscribe_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('content')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_subscribe_types');
    }
}
