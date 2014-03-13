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

} #CarritoController
