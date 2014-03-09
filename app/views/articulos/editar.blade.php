@extends('layouts.master')

@section('contenido')

<div class="container">

    <div class="col-md-8">
        <h1>Datos del artículo</h1>
        <div class="alert alert-info">
            Registrado por {{ $articulo->user->nombre }} el día {{ date_format($articulo->updated_at, 'd-m-Y') }} a las {{ date_format($articulo->updated_at, 'H:i:s') }}
        </div>
        {{ Form::open(array('url' => 'articulos/editar', 'role' => 'form')) }}

            {{ Form::hidden('id', $articulo->id) }}

            <div class="input-group">
                <span class="input-group-addon">Nombre: </span>
                {{ Form::text('nombre', $articulo->nombre, array('class' => 'form-control', 'placeholder' => 'Nombre del artículo', 'required', 'maxlength' => '255')) }}
                @if($errors->has('nombre'))
                    {{ Form::label('nombre', $errors->first('nombre'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <div class="input-group">
                <span class="input-group-addon">Precio: $</span>
                {{ Form::input('number', 'precio', $articulo->precio, array('class' => 'form-control', 'min' => '0.01', 'step' => '0.01', 'max' => '99999999999999.99', 'title' => 'Precio', 'required')) }}
                <span class="input-group-addon">IVA: </span>
                    {{ Form::select('iva', array('null' => 'Excento', '0' => '0', '5' => '5', '16' => '16'), $articulo->iva, array('class' => 'form-control', 'required')) }}
                <span class="input-group-addon">%</span>
            </div>

            <div class="form-group">
                {{ Form::label('notas', 'Datos adicionales', array('class' => 'label label-success')) }}
                {{ Form::textarea('notas', $articulo->notas, array('class' => 'form-control', 'placeholder' => 'Código de barras, tamaño, peso, etc.', 'maxlength' => '255', 'rows' => '5')) }}
                @if($errors->has('notas'))
                    {{ Form::label('notas', $errors->first('notas'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <div class="input-group">
                <span class="input-group-addon">Password: </span>
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
                @if($errors->has('password'))
                    {{ Form::label('password', $errors->first('password'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <p> </p>

            {{ Form::submit('Guardar cambios', array('class' => 'btn btn-primary')) }}
            <a href="{{ url('articulos/listado') }}" class="btn btn-info">Ir a listado</a>

        {{ Form::close() }}
    </div>
</div>

@stop