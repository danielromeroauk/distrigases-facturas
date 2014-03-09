<?php

class Factura extends Eloquent
{
    protected $table = 'facturas';

    public function user()
    {
        return $this->belongsTo('User');
    }
}
