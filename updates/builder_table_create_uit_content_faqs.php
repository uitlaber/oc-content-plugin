<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUitContentFaqs extends Migration
{
    public function up()
    {
        Schema::create('uit_content_faqs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('question');
            $table->text('answer')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('uit_content_faqs');
    }
}
