<?php

class CotizacionItem extends Eloquent
{
    protected $table = 'cotizacion_items';

    public function articulo()
    {
        return $this->belongsTo('Articulo');
    }
}
