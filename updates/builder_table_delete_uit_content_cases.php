<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteUitContentCases extends Migration
{
    public function up()
    {
        Schema::dropIfExists('uit_content_cases');
    }
    
    public function down()
    {
        Schema::create('uit_content_cases', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 191);
            $table->string('slug', 191);
            $table->text('content')->nullable();
            $table->boolean('published');
            $table->text('meta')->nullable();
            $table->text('open_graph')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('images')->nullable();
        });
    }
}
