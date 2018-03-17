<?php

use Illuminate\Database\Schema\Blueprint;

class CreateConstructorsRatesTable extends BaseMigration
{
    protected $table = 'constructors_rates';

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
            $table->double('rate');
        });
    }
}
