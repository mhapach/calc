<?php

use Illuminate\Database\Schema\Blueprint;

class CreatePartsTable extends BaseMigration
{
    protected $table = 'parts';

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
            $table->unsignedInteger('group_id');
            $table->string('title', 400);
            $table->string('article', 15);
            $table->tinyInteger('unit', false, true);
            $table->double('unit_price');
            $table->double('price');
            $table->timestamps();
        });
    }
}
