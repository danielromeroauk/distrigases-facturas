<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloImagenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articulo_imagen', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('articulo_id')->unsigned();
			$table->string('ruta');
			$table->integer('user_id')->unsigned();
			$table->timestamps();

			$table->foreign('articulo_id')
				->references('id')->on('articulos')
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
		Schema::drop('articulo_imagen');
	}

}
