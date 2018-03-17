<?php

use Illuminate\Database\Schema\Blueprint;

class CreateUsersRolesTable extends BaseMigration
{
    protected $table = 'users_roles';

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
        });
    }
}
