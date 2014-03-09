@extends('layouts.master')

@section('contenido')

<div class="container">
    <div class="col-md-8">
        <h1>Datos de perfil</h1>

        {{ Form::open(array('url' => 'users/editar', 'role' => 'form')) }}

            {{ Form::hidden('id', $usuario->id) }}

            <div class="input-group">
                <span class="input-group-addon">Email: </span>
                {{ Form::email('email', $usuario->email, array('class' => 'form-control', 'placeholder' => 'Email', 'required', 'maxlength' => '255')) }}
                @if($errors->has('email'))
                    {{ Form::label('email', $errors->first('email'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <div class="input-group">
                <span class="input-group-addon">Nombre: </span>
                {{ Form::text('nombre', $usuario->nombre, array('class' => 'form-control', 'placeholder' => 'Nombre completo', 'required', 'maxlength' => '255')) }}
                @if($errors->has('nombre'))
                    {{ Form::label('nombre', $errors->first('nombre'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <div class="input-group">
                <span class="input-group-addon">Nuevo password: </span>
                {{ Form::password('password2', array('class' => 'form-control', 'placeholder' => 'Nuevo password', 'required')) }}
            </div>

            <div class="input-group">
                <span class="input-group-addon">Confirmar nuevo password: </span>
                {{ Form::password('password2_confirmation', array('class' => 'form-control', 'placeholder' => 'Nuevo password', 'required')) }}
                @if($errors->has('password2'))
                    {{ Form::label('password2', $errors->first('password2'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <div class="form-group">
                {{ Form::label('notas', 'Datos adicionales', array('class' => 'label label-success')) }}
                {{ Form::textarea('notas', $usuario->notas, array('class' => 'form-control', 'placeholder' => 'Cédula, cargo, teléfono, dirección, etc.', 'maxlength' => '255', 'rows' => '5')) }}
                @if($errors->has('notas'))
                    {{ Form::label('notas', $errors->first('notas'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <div class="input-group">
                <span class="input-group-addon">Password de administrador: </span>
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password de administrador', 'required')) }}
                @if($errors->has('password'))
                    {{ Form::label('password', $errors->first('password'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <p> </p>

            {{ Form::submit('Guardar cambios', array('class' => 'btn btn-primary')) }}
            <a href="{{ url('users/listado') }}" class="btn btn-info">Ir a listado</a>

        {{ Form::close() }}
    </div>
</div>

@stop