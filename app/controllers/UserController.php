<?php

class UserController extends BaseController {

    public function getIndex()
    {
        return Redirect::to('/');

    } #getIndex

    public function postIndex()
    {
        $input = Input::all();

        $credenciales = array(
            'email' => $input['email'],
            'password' => $input['password']
        );

        if (Auth::attempt($credenciales)) {

            return Redirect::to('/');

        } else {

            $mensaje = 'El email o el password introducidos no son correctos.';
            Session::flash('mensajeError', $mensaje);

            return Redirect::to('/');

        }

    } #postIndex

    public function getLogout()
    {
        Auth::logout();
        Session::flush();

        return Redirect::to('/');

    } #getLogout

    public function getCambiarPassword()
    {
        return View::make('users.cambiarPassword');

    } #getCambiarPassword

    public function postCambiarPassword()
    {
        $input = Input::all();

        $reglas = array(
            'password' => 'required',
            'password2' => 'confirmed|min:5|max:100'
        );

        $mensajes = array(
            'required' => 'Este campo es obligatorio.',
            'password2.confirmed' => 'El nuevo password no coincide.',
            'password2.min' => 'El nuevo password debe tener al menos 5 caracteres.'
        );

        $validador = Validator::make($input, $reglas, $mensajes);

        if($validador->passes())
        {
            $usuario = Auth::user();
            $chequeo = Hash::check($input['password'], $usuario->password);

            if($chequeo)
            {
                $usuario->password = Hash::make($input['password2']);
                $usuario->save();

                Session::flash('mensajeOk', 'Has cambiado tu password con éxito.');

                return Redirect::to('users/cambiar-password');

            } else {

                Session::flash('mensajeError', 'El password actual no es válido.');

                return Redirect::to('users/cambiar-password');
            }

        } else {

            return Redirect::to('users/cambiar-password')->withErrors($validador);
        }

    } #postCambiarPassword

    public function getModificarPerfil()
    {
        $usuario = Auth::user();

        return View::make('users.modificarPerfil')
            ->with(compact('usuario'));

    } #getModificarPerfil

    public function postModificarPerfil()
    {
        $input = Input::all();

        $reglas = array(
            'password' => 'required',
            'email' => 'required|email|max:255',
            'nombre' => 'required|max:255'
        );

        $validador = Validator::make($input, $reglas);

        if($validador->passes())
        {
            $usuario = Auth::user();
            $chequeo = Hash::check($input['password'], $usuario->password);

            if($chequeo)
            {
                $usuario->email = $input['email'];
                $usuario->nombre = $input['nombre'];
                $usuario->notas = $input['notas'];
                $usuario->save();

                Session::flash('mensajeOk', 'Los cambios de perfil se han guardado con éxito.');

                return Redirect::to('users/modificar-perfil');

            } else {

                Session::flash('mensajeError', 'El password no es válido.');

                return Redirect::to('users/modificar-perfil')->withInput();
            }

        } else {

            return Redirect::to('users/modificar-perfil')->withErrors($validador)->withInput();
        }

    } #postModificarPerfil

    public function getListado()
    {
        $usuarios = User::OrderBy('nombre', 'asc')->paginate(10);

        return View::make('users.listado')->with(compact('usuarios'));

    } #getListado

    public function getEditar($id=null)
    {
        if (is_numeric($id) && $id != '1')
        {
            $usuario = User::find($id);

            return View::make('users.editar')->with(compact('usuario'));

        } else {

            return Redirect::to('users/listado');
        }

    } #getEditar

public function postEditar()
    {
        $input = Input::all();

        $reglas = array(
            'password' => 'required',
            'email' => 'required|email|max:255',
            'nombre' => 'required|max:255',
            'password2' => 'confirmed|min:5|max:100'
        );

        $validador = Validator::make($input, $reglas);

        if($validador->passes())
        {
            $usuario = Auth::user();
            $chequeo = Hash::check($input['password'], $usuario->password);

            if($chequeo)
            {
                $usuario = User::find($input['id']);
                $usuario->email = $input['email'];
                $usuario->nombre = $input['nombre'];
                $usuario->notas = $input['notas'];
                $usuario->password = Hash::make($input['password2']);
                $usuario->save();

                Session::flash('mensajeOk', 'Los cambios de perfil se han guardado con éxito.');

                return Redirect::to('users/editar/'. $usuario->id);

            } else {

                Session::flash('mensajeError', 'El password no es válido.');

                return Redirect::to('users/editar/'. $input['id'])->withInput();
            }

        } else {

            return Redirect::to('users/editar/'. $input['id'])->withErrors($validador)->withInput();
        }

    } #postEditar

    public function getNuevo()
    {
        $usuario = new User();

        return View::make('users.nuevo')->with(compact('usuario'));

    } #getNuevo

    public function postNuevo()
    {
        $input = Input::all();

        $reglas = array(
            'password' => 'required',
            'email' => 'required|email|max:255',
            'nombre' => 'required|max:255',
            'password2' => 'confirmed|min:5|max:100'
        );

        $validador = Validator::make($input, $reglas);

        if($validador->passes())
        {
            $usuario = Auth::user();
            $chequeo = Hash::check($input['password'], $usuario->password);

            if($chequeo)
            {
                $usuario = new User();
                $usuario->email = $input['email'];
                $usuario->nombre = $input['nombre'];
                $usuario->notas = $input['notas'];
                $usuario->password = Hash::make($input['password2']);
                $usuario->rol = 'facturador';
                $usuario->save();

                Session::flash('mensajeOk', 'El nuevo usuario se ha registrado con éxito.');

                return Redirect::to('users/editar/'. $usuario->id);

            } else {

                Session::flash('mensajeError', 'El password no es válido.');

                return Redirect::to('users/nuevo')->withInput();
            }

        } else {

            return Redirect::to('users/nuevo')->withErrors($validador)->withInput();
        }

    } #postNuevo

} #UserController