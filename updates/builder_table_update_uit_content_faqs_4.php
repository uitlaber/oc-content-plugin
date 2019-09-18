<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentFaqs4 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_faqs', function($table)
        {
            $table->string('question_email')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_faqs', function($table)
        {
            $table->dropColumn('question_email');
        });
    }
}
