@extends('layouts.master')

@section('contenido')

<div class="container">
    <div class="col-xs-10 col-sm-6 col-md-4">
        <h1>Cambia tu password</h1>

        {{ Form::open(array('url' => 'users/cambiar-password', 'role' => 'form')) }}

            <div class="form-group">
                {{ Form::label('password', 'Password actual', array('class' => 'label label-success')) }}
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password actual', 'required')) }}
                @if($errors->has('password'))
                    {{ Form::label('password', $errors->first('password'), array('class' => 'label label-warning')) }}
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

            {{ Form::submit('Cambiar', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}
    </div>
</div>

@stop