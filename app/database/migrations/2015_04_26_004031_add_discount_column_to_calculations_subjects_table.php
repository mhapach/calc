<?php

use Illuminate\Database\Schema\Blueprint;

class AddDiscountColumnToCalculationsSubjectsTable extends BaseMigration
{

    protected $table = 'calculations_subjects';

    public function up()
    {
        Schema::table($this->table, function (Blueprint $table)
        {
            $table->double('discount');
        });
    }

    public function down()
    {
        Schema::create($this->table, function (Blueprint $table)
        {
            $table->dropColumn('discount');
        });
    }

}
