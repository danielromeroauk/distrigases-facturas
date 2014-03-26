<?php

class ArticuloImagen extends Eloquent
{
    protected $table = 'articulo_imagen';

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function articulo()
    {
        return $this->belongsTo('Articulo');
    }
}