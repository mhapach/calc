<?php

use Illuminate\Database\Schema\Blueprint;

class CreateCalculationsTable extends BaseMigration
{
    protected $table = 'calculations';

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
            $table->string('description', 400);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('additional_coefficient_id');
            $table->timestamp('install_at');
            $table->string('install_address', 400);
            $table->timestamp('delivery_at');
            $table->string('delivery_address', 400);
            $table->double('cost_manufacturing');
            $table->double('cost_construct');
            $table->double('cost_assembly');
            $table->double('cost_total');
            $table->double('margin');
            $table->double('outlay');
            $table->double('discount');
            $table->double('delivery');
            $table->double('install');
            $table->tinyInteger('status', false, true);
            $table->timestamps();
        });
    }
}
