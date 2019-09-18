<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentRatings3 extends Migration
{
    public function up()
    {
        Schema::rename('uit_content_ratingables', 'uit_content_ratings');
    }
    
    public function down()
    {
        Schema::rename('uit_content_ratings', 'uit_content_ratingables');
    }
}
