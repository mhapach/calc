<?php

use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends BaseMigration
{
    protected $table = 'orders';

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
            $table->unsignedInteger('contractor_id');
            $table->unsignedInteger('subject_id');
            $table->text('description');
            $table->tinyInteger('status', false, true);
            $table->timestamp('called_at');
            $table->timestamp('next_call_at');
            $table->double('cost');
            $table->timestamps();

            $table->index('calculation_id');
            $table->index('contractor_id');
            $table->index('status');
        });
    }
}
