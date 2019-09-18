<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentPages3 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_pages', function($table)
        {
            $table->integer('product_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_pages', function($table)
        {
            $table->dropColumn('product_id');
        });
    }
}
