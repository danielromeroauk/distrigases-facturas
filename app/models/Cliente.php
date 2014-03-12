<?php

class Cliente extends Eloquent {

	protected $table = 'clientes';

	public function user()
	{
		return $this->belongsTo('User');
	}

    public function siguientePedido()
    {
        $pedidoAnterior = Factura::where('cliente_id', '=', $this->id)->orderBy('pedido', 'desc')->first();

        if($pedidoAnterior)
        {
            return $pedidoAnterior->pedido + 1;

        } else {

            return 1;
        }
    }

}