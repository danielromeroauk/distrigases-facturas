@extends('layouts.master')

@section('contenido')

<div class="container">
    <div class="col-xs-10 col-sm-6 col-md-4">
        <h1>Datos de perfil</h1>

        {{ Form::open(array('url' => 'users/modificar-perfil', 'role' => 'form')) }}

            <div class="form-group">
                {{ Form::label('password', 'Password', array('class' => 'label label-success')) }}
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
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

            {{ Form::submit('Guardar cambios', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}
    </div>
</div>

@stop