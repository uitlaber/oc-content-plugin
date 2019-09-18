<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentPages extends Migration
{
    public function up()
    {
        Schema::create('uit_content_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->integer('order')->nullable();
            $table->text('images')->nullable();
            $table->text('meta');
            $table->text('open_graph');
            $table->boolean('published');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_pages');
    }
}
