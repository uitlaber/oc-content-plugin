<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentPages2 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_pages', function($table)
        {
            $table->integer('type')->nullable();
            $table->string('author')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_pages', function($table)
        {
            $table->dropColumn('type');
            $table->dropColumn('author');
        });
    }
}
