<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Article extends Eloquent {

	protected $table = 'articles';

	public function user()
	{
		return $this->belongsTo('User');
	}

}