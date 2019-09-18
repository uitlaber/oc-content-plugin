<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentPosts2 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_posts', function($table)
        {
            $table->dropColumn('meta');
            $table->dropColumn('open_graph');
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_posts', function($table)
        {
            $table->text('meta')->nullable();
            $table->text('open_graph')->nullable();
        });
    }
}
