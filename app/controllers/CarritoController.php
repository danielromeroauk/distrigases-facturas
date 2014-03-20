<?php

class CarritoController extends BaseController {

    public function getIndex()
    {

        if (Session::has('carrito')) {

            return View::make('articulos.carrito');

        } else {

            return Redirect::to('articulos');
        }

    } #getIndex

    public function postAgregar()
    {
        $input = Input::all();

        $articulo = Articulo::find($input['id']);
        $cantidad = $input['cantidad'];
        $carrito = array();

        if (Session::has('carrito')) {
            $carrito = Session::get('carrito');
        }

        $carrito[$articulo->id] = array('articulo' => $articulo, 'cantidad' => $cantidad);

        Session::put('carrito', $carrito);

        return Redirect::to('carrito');

    } #postAgregar

    public function getLimpiar()
    {
        Session::forget('carrito');

        return Redirect::to('carrito');

    } #postAgregar

    public function getQuitarItem($idArticulo)
    {
        $carrito = array();

        if (Session::has('carrito')) {
            $carrito = Session::get('carrito');
        }

        unset($carrito[$idArticulo]);

        Session::put('carrito', $carrito);

        return Redirect::to('carrito');

    } #getQuitarItem

    public static function calcularTotal($dato)
    {
        if (!Session::has('carrito')) {
            return View::make('articulos');
        }

        $carrito = Session::get('carrito');

        $totales = array('excento' => 0, 'gravado' => 0, 'iva' => 0, 'total' => 0);

        foreach ($carrito as $item) {
            if(is_numeric($item['articulo']->iva))
            {
                $totales['gravado'] += $item['cantidad'] * $item['articulo']->precio;
                $totales['iva'] += $item['cantidad'] * ($item['articulo']->precio * ($item['articulo']->iva / 100));
            } else {
                $totales['excento'] += $item['cantidad'] * $item['articulo']->precio;
            }
        }

        $totales['total'] = $totales['excento'] + $totales['gravado'] + $totales['iva'];

        return $totales[$dato];

    } #calcularTotal

} #CarritoController
