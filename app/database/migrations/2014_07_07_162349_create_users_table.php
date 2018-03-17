<?php

use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends BaseMigration
{
    protected $table = 'users';

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
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('username');
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->string('persist_code')->nullable();
            $table->string('reset_password_code')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('remember_token')->nullable();
            $table->tinyInteger('role', false, true);
            $table->tinyInteger('status', false, true);
            $table->double('rate')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('username');
            $table->unique('email');
            $table->index('reset_password_code');
            $table->index('remember_token');
            $table->index('status');
            $table->index('role');
        });
    }
}

