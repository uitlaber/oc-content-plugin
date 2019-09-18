<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentFaqs extends Migration
{
    public function up()
    {
        Schema::table('uit_content_faqs', function($table)
        {
            $table->string('question_name')->nullable();
            $table->string('answer_name')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_faqs', function($table)
        {
            $table->dropColumn('question_name');
            $table->dropColumn('answer_name');
        });
    }
}
