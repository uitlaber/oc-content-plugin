<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentReviews extends Migration
{
    public function up()
    {
        Schema::table('uit_content_reviews', function($table)
        {
            $table->boolean('published');
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_reviews', function($table)
        {
            $table->dropColumn('published');
            $table->increments('id')->unsigned()->change();
        });
    }
}
