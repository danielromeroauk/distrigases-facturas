<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cotizacion_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cotizacion_id')->unsigned();
			$table->integer('articulo_id')->unsigned();
			$table->decimal('cantidad', 16, 2)->unsigned();
			$table->decimal('precio', 16, 2)->unsigned();
            $table->tinyInteger('iva')->unsigned()->nullable();
            $table->timestamps();

			$table->foreign('articulo_id')
				->references('id')->on('articulos')
				->onDelete('NO ACTION')
				->onUpdate('CASCADE');

			$table->foreign('cotizacion_id')
				->references('id')->on('cotizaciones')
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
		Schema::drop('cotizacion_items');
	}

}
