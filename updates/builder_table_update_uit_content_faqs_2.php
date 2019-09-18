<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentFaqs2 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_faqs', function($table)
        {
            $table->integer('product_id')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_faqs', function($table)
        {
            $table->dropColumn('product_id');
        });
    }
}
