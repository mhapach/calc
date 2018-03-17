<?php

use Illuminate\Database\Schema\Blueprint;

class CreateCalculationsSubjectsTable extends BaseMigration
{
    protected $table = 'calculations_subjects';

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
            $table->unsignedInteger('calculation_id');
            $table->string('title', 400);
            $table->tinyInteger('num', false, true);
            $table->double('x');
            $table->double('y');
            $table->double('z');
            $table->double('volume');
            $table->double('margin');
            $table->double('outlay');
            $table->double('cost_manufacturing');
            $table->double('cost_construct');
            $table->double('cost_assembly');
            $table->double('cost_total');
            $table->unsignedInteger('constructor_rate_id');
            $table->timestamps();
        });
    }
}
