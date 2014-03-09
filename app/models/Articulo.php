<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Articulo extends Eloquent {

	protected $table = 'articulos';

	public function user()
	{
		return $this->belongsTo('User');
	}

}