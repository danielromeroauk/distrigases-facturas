@extends('layouts.master')

@section('contenido')

<div class="container">
    <h1>Contenido del carrito</h1>
    <table class="table table-hover table-striped">
        <thead>
            <th>Id</th>
            <th>Artículo</th>
            <th>Cantidad</th>
            <th>Acción</th>
        </thead>
        <tbody>
            @foreach(Session::get('carrito') as $item)
                <tr>
                    <td>
                        {{ $item['articulo']->id }}
                    </td>
                    <td>
                        {{ $item['articulo']->nombre }}
                    </td>
                    <td>
                        {{ $item['cantidad'] }}
                    </td>
                    <td>
                        <a href="{{ url('carrito/quitar-item/'. $item['articulo']->id) }}" class="btn btn-warning btn-xs">
                            <span class="glyphicon glyphicon-remove"></span>
                            Quitar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop
