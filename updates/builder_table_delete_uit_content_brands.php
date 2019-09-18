<?php namespace Uit\Content\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteUitContentBrands extends Migration
{
    public function up()
    {
        Schema::dropIfExists('uit_content_brands');
    }
    
    public function down()
    {
        Schema::create('uit_content_brands', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 191);
            $table->string('slug', 191);
            $table->text('content')->nullable();
            $table->string('logo', 191)->nullable();
        });
    }
}
