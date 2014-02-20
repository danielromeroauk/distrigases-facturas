<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Client extends Eloquent {

	protected $table = 'clients';

	public function user()
	{
		return $this->belongsTo('User');
	}

}