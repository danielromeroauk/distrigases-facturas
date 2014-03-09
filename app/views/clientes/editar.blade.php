@extends('layouts.master')

@section('contenido')

<div class="container">
    <div class="col-md-8">
        <h1>Datos del cliente</h1>
        <div class="alert alert-info">
            Registrado por {{ $cliente->user->nombre }} el día {{ date_format($cliente->updated_at, 'd-m-Y') }} a las {{ date_format($cliente->updated_at, 'H:i:s') }}
        </div>

        {{ Form::open(array('url' => 'clientes/editar', 'role' => 'form')) }}

            {{ Form::hidden('id', $cliente->id) }}

            <div class="input-group">
                <span class="input-group-addon">NIT: </span>
                {{ Form::text('nit', $cliente->nit, array('class' => 'form-control', 'placeholder' => 'NIT', 'required', 'maxlength' => '100')) }}
                @if($errors->has('nit'))
                    {{ Form::label('nit', $errors->first('nit'), array('class' => 'label label-warning')) }}
                @endif
            </div>

            <div class="input-group">
                <span class="input-group-addon">Razón social: </span>
                {{ Form::text('nombre', $cliente->nombre, array('class' => 'form-control', 'placeholder' => 'Nombre completo o razón social', 'required', 'maxlength' => '255')) }}
                @if($errors->has('nombre'))
                    {{ Form::label('nombre', $errors->first('nombre'), array('class' => 'label label-warning')) }}
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-addon">Dirección: </span>
                {{ Form::text('direccion', $cliente->direccion, array('class' => 'form-control', 'placeholder' => 'Dirección', 'maxlength' => '255')) }}
                @if($errors->has('direccion'))
                    {{ Form::label('direccion', $errors->first('direccion'), array('class' => 'label label-warning')) }}
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-addon">Teléfono: </span>
                {{ Form::text('telefono', $cliente->telefono, array('class' => 'form-control', 'placeholder' => 'Teléfono', 'maxlength' => '100')) }}
                @if($errors->has('telefono'))
                    {{ Form::label('telefono', $errors->first('telefono'), array('class' => 'label label-warning')) }}
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-addon">Email: </span>
                {{ Form::email('email', $cliente->email, array('class' => 'form-control', 'placeholder' => 'Email', 'maxlength' => '255')) }}
                @if($errors->has('email'))
                    {{ Form::label('email', $errors->first('email'), array('class' => 'label label-warning')) }}
                @endif
            </div>
            <div class="form-group">
                {{ Form::label('notas', 'Datos adicionales', array('class' => 'label label-success')) }}
                {{ Form::textarea('notas', $cliente->notas, array('class' => 'form-control', 'placeholder' => 'Contacto, cargo, etc.', 'maxlength' => '255', 'rows' => '5')) }}
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
            <a href="{{ url('clientes/listado') }}" class="btn btn-info">Ir a listado</a>

        {{ Form::close() }}
    </div>
</div>

@stop