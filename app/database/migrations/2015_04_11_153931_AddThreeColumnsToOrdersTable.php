<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeColumnsToOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function (Blueprint $table)
		{
			$table->string('constructor_name');
			$table->string('designer_name');
			$table->string('installer_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function (Blueprint $table)
		{
			$table->dropColumn('constructor_name');
			$table->dropColumn('designer_name');
			$table->dropColumn('installer_name');
		});
	}

}
