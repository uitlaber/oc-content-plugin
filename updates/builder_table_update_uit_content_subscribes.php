<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentSubscribes extends Migration
{
    public function up()
    {
        Schema::table('uit_content_subscribes', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->string('email')->change();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_subscribes', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->increments('id')->unsigned()->change();
            $table->string('email', 191)->change();
        });
    }
}
