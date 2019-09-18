<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentReviews3 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_reviews', function($table)
        {
            $table->string('username');
            $table->string('company')->nullable();
            $table->dropColumn('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_reviews', function($table)
        {
            $table->dropColumn('username');
            $table->dropColumn('company');
            $table->integer('user_id')->nullable();
        });
    }
}
