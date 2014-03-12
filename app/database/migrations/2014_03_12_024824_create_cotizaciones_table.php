<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cotizaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->string('concepto', 255);
			$table->string('notas', 255);
			$table->integer('user_id')->unsigned();
			$table->timestamps();

			$table->foreign('cliente_id')
				->references('id')->on('clientes')
				->onDelete('NO ACTION')
				->onUpdate('CASCADE');

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
		Schema::drop('cotizaciones');
	}

}
