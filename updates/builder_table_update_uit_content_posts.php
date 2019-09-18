<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentPosts extends Migration
{
    public function up()
    {
        Schema::table('uit_content_posts', function($table)
        {
            $table->boolean('published')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_posts', function($table)
        {
            $table->boolean('published')->nullable(false)->change();
        });
    }
}
