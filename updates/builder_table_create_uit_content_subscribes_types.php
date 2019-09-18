<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentSubscribesTypes extends Migration
{
    public function up()
    {
        Schema::create('uit_content_subscribes_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('type_id');
            $table->integer('subscribe_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_subscribes_types');
    }
}
