<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentTypes extends Migration
{
    public function up()
    {
        Schema::table('uit_content_types', function($table)
        {
            $table->boolean('has_page')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_types', function($table)
        {
            $table->dropColumn('has_page');
        });
    }
}
