<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Cliente extends Eloquent {

	protected $table = 'clientes';

	public function user()
	{
		return $this->belongsTo('User');
	}

}