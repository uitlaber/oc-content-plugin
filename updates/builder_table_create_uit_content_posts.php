<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentPosts extends Migration
{
    public function up()
    {
        Schema::create('uit_content_posts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->boolean('published');
            $table->integer('order')->nullable();
            $table->text('images')->nullable();
            $table->text('meta')->nullable();
            $table->text('open_graph')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_posts');
    }
}
