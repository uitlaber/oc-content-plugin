<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentSubscribes extends Migration
{
    public function up()
    {
        Schema::create('uit_content_subscribes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email');
            $table->text('params')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_subscribes');
    }
}
