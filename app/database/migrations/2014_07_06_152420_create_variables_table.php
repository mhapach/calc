<?php

use Illuminate\Database\Schema\Blueprint;

class CreateVariablesTable extends BaseMigration
{
    protected $table = 'variables';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table)
        {
            $table->string('name');
            $table->primary('name');
            $table->double('value');
            $table->string('unit');
        });
    }
}
