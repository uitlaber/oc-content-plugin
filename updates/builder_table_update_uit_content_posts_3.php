<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentPosts3 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_posts', function($table)
        {
            $table->integer('read_time')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_posts', function($table)
        {
            $table->dropColumn('read_time');
        });
    }
}
