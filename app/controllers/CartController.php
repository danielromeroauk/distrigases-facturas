<?php

class CartController extends BaseController {

    public function getIndex()
    {

        if (Session::has('cart')) {

            return View::make('articles.carrito');

        } else {

            return Redirect::to('articles');
        }

    } #getIndex

    public function postAgregar()
    {
        $input = Input::all();

        $articulo = Article::find($input['id']);
        $cantidad = $input['cantidad'];
        $cart = array();

        if (Session::has('cart')) {
            $cart = Session::get('cart');
        }

        $cart[$articulo->id] = array('articulo' => $articulo, 'cantidad' => $cantidad);

        Session::put('cart', $cart);

        return Redirect::to('carrito/index');

    } #postAgregar

    public function getLimpiar()
    {
        Session::forget('cart');

        return Redirect::to('carrito/index');

    } #postAgregar

    public function getQuitarItem($idArticle)
    {
        $cart = array();

        if (Session::has('cart')) {
            $cart = Session::get('cart');
        }

        unset($cart[$idArticle]);

        Session::put('cart', $cart);

        return Redirect::to('carrito/index');

    } #getQuitarItem

} #CartController
