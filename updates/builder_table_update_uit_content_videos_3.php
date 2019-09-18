<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentVideos3 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_videos', function($table)
        {
            $table->boolean('published')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_videos', function($table)
        {
            $table->dropColumn('published');
        });
    }
}
