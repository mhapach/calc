<?php

use Illuminate\Database\Schema\Blueprint;

class CreateElementsTable extends BaseMigration {

    protected $table = 'elements';

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
            $table->unsignedInteger('category_id');
            $table->tinyInteger('sort')->default(0);
        });
    }

}
