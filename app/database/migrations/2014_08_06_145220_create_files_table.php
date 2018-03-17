<?php

use Illuminate\Database\Schema\Blueprint;

class CreateFilesTable extends BaseMigration
{
    protected $table = 'files';

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
            $table->string('src', 255);
            $table->string('name', 255);
            $table->string('fileable_type', 255);
            $table->unsignedInteger('fileable_id');
            $table->unsignedInteger('created_by');
            $table->timestamps();
        });
    }
}
