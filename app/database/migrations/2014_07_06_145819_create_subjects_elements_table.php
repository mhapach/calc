<?php

use Illuminate\Database\Schema\Blueprint;

class CreateSubjectsElementsTable extends BaseMigration
{
    protected $table = 'subjects_elements';

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
            $table->double('price');
            $table->double('unit_price');
            $table->tinyInteger('total');
            $table->double('sum');
            $table->unsignedInteger('subject_id');
            $table->string('title', 400);
            $table->tinyInteger('character', false, true);
            $table->double('x');
            $table->double('y');
            $table->double('z');
            $table->double('area');
            $table->double('volume');
            $table->unsignedInteger('part_id');
        });
    }
}
