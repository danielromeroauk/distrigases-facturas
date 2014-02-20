<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClients extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('nit', 100);
			$table->string('nombre', 255);
			$table->string('direccion', 255);
			$table->string('telefono', 100);
			$table->string('email', 255);
			$table->string('notas', 255);
			$table->bigInteger('user_id')->unsigned();
			$table->timestamps();

			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('NO ACTION')
				->onUpdate('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('clients', function(Blueprint $table){
			$table->dropForeign('clients_user_id_foreign');
		});

		Schema::drop('clients');
	}

}