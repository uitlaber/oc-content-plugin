<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentJobs extends Migration
{
    public function up()
    {
        Schema::table('uit_content_jobs', function($table)
        {
            $table->boolean('published')->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->string('name')->change();
            $table->string('salary')->change();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_jobs', function($table)
        {
            $table->dropColumn('published');
            $table->increments('id')->unsigned()->change();
            $table->string('name', 191)->change();
            $table->string('salary', 191)->change();
        });
    }
}
