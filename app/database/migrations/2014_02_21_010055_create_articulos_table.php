<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articulos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 255)->unique();
			$table->string('notas', 255);
			$table->decimal('precio', 16, 2)->unsigned();
            $table->tinyInteger('iva')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
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
		Schema::drop('articulos');
	}

}
