<?php

use Illuminate\Database\Schema\Blueprint;

class CreateContractorsTable extends BaseMigration
{
    protected $table = 'contractors';

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
            $table->string('title')->nullable();
            $table->string('email');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('function')->nullable();
            $table->tinyInteger('status', false, true);
            $table->string('description', 1000)->nullable();
            $table->timestamps();
        });
    }
}
