<?php

class Articulo extends Eloquent {

	protected $table = 'articulos';

	public function user()
	{
		return $this->belongsTo('User');
	}

}