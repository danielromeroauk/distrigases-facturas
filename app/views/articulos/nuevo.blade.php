@extends('layouts.master')

@section('contenido')

<div class="container">
    <div class="col-xs-10 col-sm-6 col-md-4">
        <h1>Datos del artículo</h1>

        {{ Form::open(array('url' => 'articles/nuevo', 'role' => 'form')) }}

            <div class="form-group">
                {{ Form::label('password', 'Password', array('class' => 'label label-success')) }}
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
                @if($errors->has('password'))
                    {{ Form::label('password', $errors->first('password'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <div class="form-group">
                {{ Form::label('nombre', 'Nombre del artículo', array('class' => 'label label-success')) }}
                {{ Form::text('nombre', $articulo->nombre, array('class' => 'form-control', 'placeholder' => 'Nombre del artículo', 'required', 'maxlength' => '255')) }}
                @if($errors->has('nombre'))
                    {{ Form::label('nombre', $errors->first('nombre'), array('class' => 'label label-warning')) }}
                @endif
            </div>
            <div class="form-group">
                    {{ Form::label('precio', 'Precio', array('class' => 'label label-success')) }}
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {{ Form::input('number', 'precio', $articulo->precio, array('class' => 'form-control', 'min' => '0.01', 'step' => '0.01', 'max' => '99999999999999.99', 'title' => 'Precio', 'required')) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('iva', 'IVA', array('class' => 'label label-success')) }}
                <div class="input-group">
                    {{ Form::select('iva', array('null' => 'Excento', '0' => '0', '5' => '5', '16' => '16'), $articulo->iva, array('class' => 'form-control', 'required')) }}
                    <span class="input-group-addon">%</span>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('notas', 'Datos adicionales', array('class' => 'label label-success')) }}
                {{ Form::textarea('notas', $articulo->notas, array('class' => 'form-control', 'placeholder' => 'Código de barras, tamaño, peso, etc.', 'maxlength' => '255', 'rows' => '5')) }}
                @if($errors->has('notas'))
                    {{ Form::label('notas', $errors->first('notas'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            {{ Form::submit('Guardar', array('class' => 'btn btn-primary')) }}
            <a href="{{ url('articles/listado') }}" class="btn btn-info">Ir a listado</a>

        {{ Form::close() }}
    </div>
</div>

@stop