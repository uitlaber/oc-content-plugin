<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentVideos2 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_videos', function($table)
        {
            $table->text('images')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_videos', function($table)
        {
            $table->dropColumn('images');
        });
    }
}
