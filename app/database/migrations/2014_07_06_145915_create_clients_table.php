<?php

use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends BaseMigration
{
    protected $table = 'clients';

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
            $table->string('last_name');
            $table->string('first_name');
            $table->string('email');
            $table->string('phone');
            $table->string('description', 1000)->nullable();
            $table->timestamp('handled_at');
            $table->tinyInteger('status', false, true);
            $table->tinyInteger('type', false, true);
            $table->timestamp('last_contact_at');
            $table->timestamp('next_contact_at');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('status');
            $table->unique('email');
        });
    }
}
