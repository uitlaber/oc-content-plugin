<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentSubscribes2 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_subscribes', function($table)
        {
            $table->integer('user_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_subscribes', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}
