<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUitContentSpecials extends Migration
{
    public function up()
    {
        Schema::table('uit_content_specials', function($table)
        {
            $table->string('image')->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->string('name')->change();
            $table->string('slug')->change();
            $table->dropColumn('images');
        });
    }
    
    public function down()
    {
        Schema::table('uit_content_specials', function($table)
        {
            $table->dropColumn('image');
            $table->increments('id')->unsigned()->change();
            $table->string('name', 191)->change();
            $table->string('slug', 191)->change();
            $table->text('images')->nullable();
        });
    }
}
