@extends('layouts.master')

@section('contenido')

<div class="container">

    <h1>Artículos</h1>

    {{ Form::open(array('url' => 'articles/filtro', 'class' => 'form-inline', 'role' => 'form', 'method' => 'get')) }}

        <div class="buscador col-xs-12 col-sm-7">
            <div class="input-group">

                <span class="input-group-addon input-sm">
                    {{ Form::radio('filtro', 'id') }}
                    Id
                </span>

                <span class="input-group-addon input-sm">
                    {{ Form::radio('filtro', 'notas') }}
                    Código de barras
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

        <a href="{{ url('articles/nuevo') }}" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-plus"></span>
            Nuevo
        </a>

    {{ Form::close() }}

    <p> </p>

    <table class="table table hover table-striped table-hover">
        <tbody>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>IVA</th>
                    <th>Notas</th>
                    <th>Acción</th>
                </tr>
            </thead>
            @foreach($articulos as $articulo)
                <tr>
                    <td>{{ $articulo->id }}</td>
                    <td>{{ $articulo->nombre }}</td>
                    <td>{{ $articulo->precio }}</td>
                    <td>
                        @if(is_numeric($articulo->iva))
                            {{ $articulo->iva }}%
                        @else
                            Excento
                        @endif
                    </td>
                    <td>{{ $articulo->notas }}</td>
                    <td>
                        <a href="{{ url('articles/editar/'. $articulo->id) }}" class="btn btn-xs btn-warning">
                            <span class="glyphicon glyphicon-edit"></span>
                            Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($input))
        {{ $articulos->appends(array_except($input, 'page'))->links(); }}
    @else
        {{ $articulos->links() }}
    @endif

</div>{{-- /.container --}}

@stop