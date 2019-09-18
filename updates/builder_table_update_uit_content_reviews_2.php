<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentReviews2 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_reviews', function($table)
        {
            $table->integer('revieweable_id')->nullable()->unsigned();
            $table->string('revieweable_type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_reviews', function($table)
        {
            $table->dropColumn('revieweable_id');
            $table->dropColumn('revieweable_type');
        });
    }
}
