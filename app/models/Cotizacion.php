<?php

class Cotizacion extends Eloquent
{
    protected $table = 'cotizaciones';

    public function user()
    {
        return $this->belongsTo('User');
    }
}
