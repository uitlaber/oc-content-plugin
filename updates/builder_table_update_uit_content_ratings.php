<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentRatings extends Migration
{
    public function up()
    {
        Schema::table('uit_content_ratings', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->string('ratingable_type')->change();
            $table->string('ip')->change();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_ratings', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->increments('id')->unsigned()->change();
            $table->string('ratingable_type', 191)->change();
            $table->string('ip', 191)->change();
        });
    }
}
