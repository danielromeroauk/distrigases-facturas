<?php

class ArticleController extends BaseController {

    public function getIndex()
    {
        return Redirect::to('/');

    } #getIndex

    public function getListado()
    {
        $articulos = Article::OrderBy('nombre', 'asc')->paginate(10);

        return View::make('articles.listado')->with(compact('articulos'));

    } #getListado

    public function getFiltro()
    {
        $input = Input::all();
        $filtro = $input['filtro'];
        $buscar = $input['buscar'];
        $articulos = array();

        if($filtro == 'id')
        {
            $articulos = Article::where('id', '=', $buscar)->paginate(10);

        } elseif ($filtro == 'notas') {

            $articulos = Article::where('notas', 'like', '%'. $buscar .'%')->paginate(10);
            $mensaje = 'Artículos que contienen <strong>'. $buscar .'</strong> en las notas.';
            Session::flash('mensajeOk', $mensaje);

        } elseif ($filtro == 'nombre') {

            $articulos = Article::where('nombre', 'like', '%'. $buscar .'%')->paginate(10);
            $mensaje = 'Artículos que contienen <strong>'. $buscar .'</strong> en el nombre.';
            Session::flash('mensajeOk', $mensaje);
        }

        return View::make('articles.listado')->with(compact('articulos', 'input'));

    } #getFiltro

    public function getEditar($id=null)
    {
        if (is_numeric($id))
        {
            $articulo = Article::find($id);

            return View::make('articles.editar')->with(compact('articulo'));

        } else {

            return Redirect::to('articles/listado');
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
                    $articulo = Article::find($input['id']);
                    $articulo->nombre = $input['nombre'];
                    $articulo->notas = $input['notas'];
                    $articulo->precio = $input['precio'];
                    $articulo->iva = ($input['iva'] == 'null') ? NULL : $input['iva'];
                    $articulo->user_id = $usuario->id;
                    $articulo->save();

                    Session::flash('mensajeOk', 'Los datos del artículo se han modificado con éxito.');

                    return Redirect::to('articles/editar/'. $articulo->id);

                } catch (Exception $e) {

                    Session::flash('mensajeError', 'No se pudieron guardar los cambios porque el nombre del artículo ya existe en otro registro.');

                    return Redirect::to('articles/editar/'. $input['id'])->withInput();
                }

            } else {

                Session::flash('mensajeError', 'El password no es válido.');

                return Redirect::to('articles/editar/'. $input['id'])->withInput();
            }

        } else {

            return Redirect::to('articles/editar/'. $input['id'])->withErrors($validador)->withInput();
        }

    } #postEditar

    public function getNuevo()
    {
        $articulo = new Article();

        return View::make('articles.nuevo')->with(compact('articulo'));

    } #getNuevo

    public function postNuevo()
    {
        $input = Input::all();

        $reglas = array(
            'nombre' => 'required|max:255|unique:articles',
            'notas' => 'max:255'
        );

        $validador = Validator::make($input, $reglas);

        if($validador->passes())
        {
            $usuario = Auth::user();
            $chequeo = Hash::check($input['password'], $usuario->password);

            if($chequeo)
            {
                $articulo = new Article();
                $articulo->nombre = $input['nombre'];
                $articulo->notas = $input['notas'];
                $articulo->precio = $input['precio'];
                $articulo->iva = ($input['iva'] == 'null') ? NULL : $input['iva'];
                $articulo->user_id = $usuario->id;
                $articulo->save();

                Session::flash('mensajeOk', 'El nuevo artículo se ha registrado con éxito.');

                return Redirect::to('articles/editar/'. $articulo->id);

            } else {

                Session::flash('mensajeError', 'El password no es válido.');

                return Redirect::to('articles/nuevo')->withInput();
            }

        } else {

            return Redirect::to('articles/nuevo')->withErrors($validador)->withInput();
        }

    } #postNuevo

} #ArticleController