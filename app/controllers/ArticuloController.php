<?php

class ArticuloController extends BaseController {

    public function getIndex()
    {
        return Redirect::to('/');

    } #getIndex

    public function getListado()
    {
        $articulos = Articulo::OrderBy('nombre', 'asc')->paginate(6);

        return View::make('articulos.listado')->with(compact('articulos'));

    } #getListado

    public function getFiltro()
    {
        $input = Input::all();
        $filtro = $input['filtro'];
        $buscar = $input['buscar'];
        $articulos = array();

        if($filtro == 'id')
        {
            $articulos = Articulo::where('id', '=', $buscar)->paginate(6);

        } elseif ($filtro == 'notas') {

            $articulos = Articulo::where('notas', 'like', '%'. $buscar .'%')->paginate(6);
            $mensaje = 'Artículos que contienen <strong>'. $buscar .'</strong> en las notas.';
            Session::flash('mensajeOk', $mensaje);

        } elseif ($filtro == 'nombre') {

            $articulos = Articulo::where('nombre', 'like', '%'. $buscar .'%')->paginate(6);
            $mensaje = 'Artículos que contienen <strong>'. $buscar .'</strong> en el nombre.';
            Session::flash('mensajeOk', $mensaje);
        }

        return View::make('articulos.listado')->with(compact('articulos', 'input'));

    } #getFiltro

    public function getEditar($id=null)
    {
        if (is_numeric($id))
        {
            $articulo = Articulo::find($id);

            return View::make('articulos.editar')->with(compact('articulo'));

        } else {

            return Redirect::to('articulos/listado');
        }

    } #getEditar

public function postEditar()
    {
        $input = Input::all();

        $reglas = array(
            'nombre' => 'required|max:255',
            'notas' => 'max:255'
        );

        $validador = Validator::make($input, $reglas);

        if($validador->passes())
        {
            $usuario = Auth::user();
            $chequeo = Hash::check($input['password'], $usuario->password);

            if($chequeo)
            {
                try
                {
                    $articulo = Articulo::find($input['id']);
                    $articulo->nombre = $input['nombre'];
                    $articulo->notas = $input['notas'];
                    $articulo->precio = $input['precio'];
                    $articulo->iva = ($input['iva'] == 'null') ? NULL : $input['iva'];
                    $articulo->user_id = $usuario->id;
                    $articulo->save();

                    Session::flash('mensajeOk', 'Los datos del artículo se han modificado con éxito.');

                    return Redirect::to('articulos/editar/'. $articulo->id);

                } catch (Exception $e) {

                    Session::flash('mensajeError', 'No se pudieron guardar los cambios porque el nombre del artículo ya existe en otro registro.');

                    return Redirect::to('articulos/editar/'. $input['id'])->withInput();
                }

            } else {

                Session::flash('mensajeError', 'El password no es válido.');

                return Redirect::to('articulos/editar/'. $input['id'])->withInput();
            }

        } else {

            return Redirect::to('articulos/editar/'. $input['id'])->withErrors($validador)->withInput();
        }

    } #postEditar

    public function getNuevo()
    {
        $articulo = new Articulo();

        return View::make('articulos.nuevo')->with(compact('articulo'));

    } #getNuevo

    public function postNuevo()
    {
        $input = Input::all();

        $reglas = array(
            'nombre' => 'required|max:255|unique:articulos',
            'notas' => 'max:255'
        );

        $validador = Validator::make($input, $reglas);

        if($validador->passes())
        {
            $usuario = Auth::user();
            $chequeo = Hash::check($input['password'], $usuario->password);

            if($chequeo)
            {
                $articulo = new Articulo();
                $articulo->nombre = $input['nombre'];
                $articulo->notas = $input['notas'];
                $articulo->precio = $input['precio'];
                $articulo->iva = ($input['iva'] == 'null') ? NULL : $input['iva'];
                $articulo->user_id = $usuario->id;
                $articulo->save();

                Session::flash('mensajeOk', 'El nuevo artículo se ha registrado con éxito.');

                return Redirect::to('articulos/editar/'. $articulo->id);

            } else {

                Session::flash('mensajeError', 'El password no es válido.');

                return Redirect::to('articulos/nuevo')->withInput();
            }

        } else {

            return Redirect::to('articulos/nuevo')->withErrors($validador)->withInput();
        }

    } #postNuevo

} #ArticuloController
