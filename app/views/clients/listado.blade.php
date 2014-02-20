@extends('layouts.master')

@section('contenido')

<div class="container">

    <h1>Clientes</h1>

    {{ Form::open(array('url' => 'clients/filtro', 'class' => 'form-inline', 'role' => 'form', 'method' => 'get')) }}

        <div class="buscador col-xs-12 col-sm-7">
            <div class="input-group">

                <span class="input-group-addon input-sm">
                    {{ Form::radio('filtro', 'nit') }}
                    NIT
                </span>

                <span class="input-group-addon input-sm">
                    {{ Form::radio('filtro', 'nombre', array('checked')) }}
                    Nombre
                </span>

                {{ Form::text('buscar', '', array('class' => 'form-control input-sm', 'placeholder' => 'Buscar...')) }}

            </div>{{-- /.input-group --}}

        </div>{{-- /.col-xs-* --}}

        <button type="submit" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-search"></span>
            Buscar
        </button>

        <a href="{{ url('clients/nuevo') }}" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-plus"></span>
            Nuevo
        </a>

    {{ Form::close() }}

    <p> </p>

    <table class="table table hover table-striped table-hover">
        <tbody>
            <thead>
                <tr>
                    <th>NIT</th>
                    <th>Nombre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nit }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>
                        <a href="{{ url('clients/editar/'. $cliente->id) }}" class="btn btn-xs btn-warning">
                            <span class="glyphicon glyphicon-edit"></span>
                            Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($input))
        {{ $clientes->appends(array_except($input, 'page'))->links(); }}
    @else
        {{ $clientes->links() }}
    @endif

</div>{{-- /.container --}}

@stop