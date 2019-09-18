<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentRatingables extends Migration
{
    public function up()
    {
        Schema::rename('uit_content_ratings', 'uit_content_ratingables');
        Schema::table('uit_content_ratingables', function($table)
        {
            $table->dropColumn('rating_id');
        });
    }
    
    public function down()
    {
        Schema::rename('uit_content_ratingables', 'uit_content_ratings');
        Schema::table('uit_content_ratings', function($table)
        {
            $table->integer('rating_id')->nullable();
        });
    }
}
