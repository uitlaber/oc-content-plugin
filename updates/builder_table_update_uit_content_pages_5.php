<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentPages5 extends Migration
{
    public function up()
    {
        Schema::table('uit_content_pages', function($table)
        {
            $table->renameColumn('type', 'type_id');
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_pages', function($table)
        {
            $table->renameColumn('type_id', 'type');
        });
    }
}
