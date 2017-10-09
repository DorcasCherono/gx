<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXJournalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('journals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('date');
			$table->string('trans_no');
			$table->integer('account_id')->unsigned()->index('journals_account_id_foreign');
			$table->float('amount', 10, 0);
			$table->string('initiated_by');
			$table->string('type');
			$table->string('description');
			$table->timestamps();
			$table->boolean('void')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('journals');
	}

}
