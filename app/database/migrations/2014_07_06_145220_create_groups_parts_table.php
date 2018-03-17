<?php

use Illuminate\Database\Schema\Blueprint;

class CreateGroupsPartsTable extends BaseMigration
{
    protected $table = 'parts_groups';

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
