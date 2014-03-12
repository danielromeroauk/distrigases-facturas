<?php

class FacturaItem extends Eloquent
{
    protected $table = 'factura_items';

    public function factura()
    {
        return $this->belongsTo('Factura');
    }

    public function articulo()
    {
        return $this->belongsTo('Articulo');
    }
}
