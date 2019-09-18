<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentPages extends Migration
{
    public function up()
    {
        Schema::table('uit_content_pages', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('name')->change();
            $table->string('slug')->change();
            $table->text('meta')->nullable()->change();
            $table->text('open_graph')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_pages', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('name', 191)->change();
            $table->string('slug', 191)->change();
            $table->text('meta')->nullable(false)->change();
            $table->text('open_graph')->nullable(false)->change();
        });
    }
}
