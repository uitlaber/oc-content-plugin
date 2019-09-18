<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentRatings2 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_ratings', function($table)
        {
            $table->integer('rating_id')->nullable();
            $table->string('ratingable_type')->change();
            $table->string('ip')->change();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_ratings', function($table)
        {
            $table->dropColumn('rating_id');
            $table->string('ratingable_type', 191)->change();
            $table->string('ip', 191)->change();
        });
    }
}
