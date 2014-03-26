<?php

class ArticuloController extends BaseController {

    public function getIndex()
    {
        return Redirect::to('articulos/listado');

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

        if ($filtro == 'nombre')
        {
            $articulos = Articulo::where('nombre', 'like', '%'. $buscar .'%')
                ->orderBy('nombre', 'asc')
                ->paginate(6);
            $mensaje = 'Artículos que contienen <strong>'. $buscar .'</strong> en el nombre.';
            Session::flash('mensajeOk', $mensaje);

        } elseif ($filtro == 'notas')
        {
            $articulos = Articulo::where('notas', 'like', '%'. $buscar .'%')
                ->orderBy('nombre', 'asc')
                ->paginate(6);
            $mensaje = 'Artículos que contienen <strong>'. $buscar .'</strong> en las notas.';
            Session::flash('mensajeOk', $mensaje);

        } elseif ($filtro == 'id')
        {
            $articulos = Articulo::where('id', '=', $buscar)->paginate(1);
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

    public function postCambiarImagen($idArticulo)
    {
        try
        {
            $input = Input::all();

            $extensiones = array('jpg', 'jpeg', 'gif', 'png', 'bmp');

            $file = Input::file("imagen");
            $extension = strtolower($file->getClientOriginalExtension());
            $size = Input::file('imagen')->getClientOriginalExtension();

            if(!in_array($extension, $extensiones))
            {
                return 'Tipo de archivo inválido';

            } elseif($file->getSize() > 10000000)
            {
                return 'El tamaño de la imagen no puede ser mayor a 10000KB.';
            }

            // $dataUpload = array(
            //     "image" => $file
            // );

            $articuloImagen = ArticuloImagen::find($idArticulo);

            if(empty($articuloImagen))
            {
                $articuloImagen = new ArticuloImagen();
                $articuloImagen->articulo_id = $idArticulo;
                $articuloImagen->ruta = $idArticulo .'.'. $extension;
                $articuloImagen->user_id = Auth::user()->id;
                $articuloImagen->save();

                Image::make($file->getRealPath())->heighten(640)->save('img/articulos/'. $articuloImagen->ruta);

                return '<span class="alert alert-success">Imagen subida con éxito.</span>';

            } else
            {
                $articuloImagen->ruta = $idArticulo .'.'. $extension;
                $articuloImagen->user_id = Auth::user()->id;
                $articuloImagen->save();

                Image::make($file->getRealPath())->heighten(640)->save('img/articulos/'. $articuloImagen->ruta);

                return '<span class="alert alert-success">Imagen actualizada con éxito.</span>';
            }

        } catch (Exception $e)
        {
            return '<span class="alert alert-danger">No fue posible guardar la imagen.'. $e->message() .'</span>';
        }

    } #postCambiarImagen

} #ArticuloController
