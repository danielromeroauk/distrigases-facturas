<?php

class ClienteController extends BaseController {

    public function getIndex()
    {
        return Redirect::to('/');

    } #getIndex

    public function getListado()
    {
        $clientes = Cliente::OrderBy('nombre', 'asc')->paginate(10);

        return View::make('clientes.listado')->with(compact('clientes'));

    } #getListado

    public function getFiltro()
    {
        $input = Input::all();
        $filtro = $input['filtro'];
        $buscar = $input['buscar'];
        $clientes = array();

        if($filtro == 'nit')
        {
            $clientes = Cliente::where('nit', 'like', '%'. $buscar .'%')->paginate(10);

        } elseif ($filtro == 'nombre') {

            $clientes = Cliente::where('nombre', 'like', '%'. $buscar .'%')->paginate(10);
        }

        $mensaje = 'Clientes que contienen <strong>'. $buscar .'</strong> en el '. strtoupper($filtro);
        Session::flash('mensajeOk', $mensaje);

        return View::make('clientes.listado')->with(compact('clientes', 'input'));

    } #getFiltro

    public function getEditar($id=null)
    {
        if (is_numeric($id))
        {
            $cliente = Cliente::find($id);

            return View::make('clientes.editar')->with(compact('cliente'));

        } else {

            return Redirect::to('clientes/listado');
        }

    } #getEditar

public function postEditar()
    {
        $input = Input::all();

        $reglas = array(
            'nit' => 'required|max:100',
            'nombre' => 'required|max:255',
            'direccion' => 'max:255',
            'telefono' => 'max:100',
            'email' => 'max:255',
            'notas' => 'max:255'
        );

        $validador = Validator::make($input, $reglas);

        if($validador->passes())
        {
            $usuario = Auth::user();
            $chequeo = Hash::check($input['password'], $usuario->password);

            if($chequeo)
            {
                $cliente = Cliente::find($input['id']);
                $cliente->nit = $input['nit'];
                $cliente->nombre = $input['nombre'];
                $cliente->direccion = $input['direccion'];
                $cliente->telefono = $input['telefono'];
                $cliente->email = $input['email'];
                $cliente->notas = $input['notas'];
                $cliente->user_id = $usuario->id;
                $cliente->save();

                Session::flash('mensajeOk', 'Los datos del cliente se han modificado con éxito.');

                return Redirect::to('clientes/editar/'. $cliente->id);

            } else {

                Session::flash('mensajeError', 'El password no es válido.');

                return Redirect::to('clientes/editar/'. $input['id'])->withInput();
            }

        } else {

            return Redirect::to('clientes/editar/'. $input['id'])->withErrors($validador)->withInput();
        }

    } #postEditar

    public function getNuevo()
    {
        $cliente = new Cliente();

        return View::make('clientes.nuevo')->with(compact('cliente'));

    } #getNuevo

    public function postNuevo()
    {
        $input = Input::all();

        $reglas = array(
            'nit' => 'required|max:100|unique:clientes',
            'nombre' => 'required|max:255',
            'direccion' => 'max:255',
            'telefono' => 'max:100',
            'email' => 'max:255',
            'notas' => 'max:255'
        );

        $validador = Validator::make($input, $reglas);

        if($validador->passes())
        {
            $usuario = Auth::user();
            $chequeo = Hash::check($input['password'], $usuario->password);

            if($chequeo)
            {
                $cliente = new Cliente();
                $cliente->nit = $input['nit'];
                $cliente->nombre = $input['nombre'];
                $cliente->direccion = $input['direccion'];
                $cliente->telefono = $input['telefono'];
                $cliente->email = $input['email'];
                $cliente->notas = $input['notas'];
                $cliente->user_id = $usuario->id;
                $cliente->save();

                Session::flash('mensajeOk', 'El nuevo cliente se ha registrado con éxito.');

                return Redirect::to('clientes/editar/'. $cliente->id);

            } else {

                Session::flash('mensajeError', 'El password no es válido.');

                return Redirect::to('clientes/nuevo')->withInput();
            }

        } else {

            return Redirect::to('clientes/nuevo')->withErrors($validador)->withInput();
        }

    } #postNuevo

} #ClientController
