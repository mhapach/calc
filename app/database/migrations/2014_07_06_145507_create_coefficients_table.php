<?php

use Illuminate\Database\Schema\Blueprint;

class CreateCoefficientsTable extends BaseMigration
{
    protected $table = 'coefficients';

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
            $table->double('range_start');
            $table->double('range_end');
            $table->double('value');
        });
    }
}
