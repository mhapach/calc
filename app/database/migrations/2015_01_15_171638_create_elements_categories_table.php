<?php

use Illuminate\Database\Schema\Blueprint;

class CreateElementsCategoriesTable extends BaseMigration {

    protected $table = 'elements_categories';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 255);
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('sort')->default(0);
        });
    }

}
