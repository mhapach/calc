<?php

use Illuminate\Database\Schema\Blueprint;

class CreateAdditionalCoefficientsTable extends BaseMigration
{
    protected $table = 'additional_coefficients';

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
            $table->string('title');
            $table->double('value');
        });
    }
}
