@extends('layouts.master')

@section('contenido')

<div class="container">
    <div class="col-xs-10 col-sm-6 col-md-4">
        <h1>Nuevo usuario</h1>

        {{ Form::open(array('url' => 'users/nuevo', 'role' => 'form')) }}

            <div class="form-group">
                {{ Form::label('password', 'Password de administrador', array('class' => 'label label-success')) }}
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password de administrador', 'required')) }}
                @if($errors->has('password'))
                    {{ Form::label('password', $errors->first('password'), array('class' => 'label label-warning')) }}
                @endif
            </div>
            <div class="form-group">
                {{ Form::label('email', 'Email', array('class' => 'label label-success')) }}
                {{ Form::email('email', $usuario->email, array('class' => 'form-control', 'placeholder' => 'Email', 'required', 'maxlength' => '255')) }}
                @if($errors->has('email'))
                    {{ Form::label('email', $errors->first('email'), array('class' => 'label label-warning')) }}
                @endif
            </div>
            <div class="form-group">
                {{ Form::label('nombre', 'Nombre completo', array('class' => 'label label-success')) }}
                {{ Form::text('nombre', $usuario->nombre, array('class' => 'form-control', 'placeholder' => 'Nombre completo', 'required', 'maxlength' => '255')) }}
                @if($errors->has('nombre'))
                    {{ Form::label('nombre', $errors->first('nombre'), array('class' => 'label label-warning')) }}
                @endif
            </div>
            <div class="form-group">
                {{ Form::label('notas', 'Datos adicionales', array('class' => 'label label-success')) }}
                {{ Form::textarea('notas', $usuario->notas, array('class' => 'form-control', 'placeholder' => 'Cédula, cargo, teléfono, dirección, etc.', 'maxlength' => '255', 'rows' => '5')) }}
                @if($errors->has('notas'))
                    {{ Form::label('notas', $errors->first('notas'), array('class' => 'label label-warning')) }}
                @endif
            </div>
            <div class="form-group">
                {{ Form::label('password2', 'Nuevo password', array('class' => 'label label-success')) }}
                {{ Form::password('password2', array('class' => 'form-control', 'placeholder' => 'Nuevo password', 'required')) }}
            </div>
            <div class="form-group">
                {{ Form::label('password2_confirmation', 'Confirmar nuevo password', array('class' => 'label label-success')) }}
                {{ Form::password('password2_confirmation', array('class' => 'form-control', 'placeholder' => 'Nuevo password', 'required')) }}
                @if($errors->has('password2'))
                    {{ Form::label('password2', $errors->first('password2'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            {{ Form::submit('Guardar', array('class' => 'btn btn-primary')) }}
            <a href="{{ url('users/listado') }}" class="btn btn-info">Ir a listado</a>

        {{ Form::close() }}
    </div>
</div>

@stop