<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentCases extends Migration
{
    public function up()
    {
        Schema::table('uit_content_cases', function($table)
        {
            $table->text('images')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_cases', function($table)
        {
            $table->dropColumn('images');
        });
    }
}
