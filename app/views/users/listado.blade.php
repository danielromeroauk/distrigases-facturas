@extends('layouts.master')

@section('contenido')

<div class="container">

    <h1>Usuarios</h1>

    <a href="{{ url('users/nuevo') }}" class="btn btn-success btn-xs">
        <span class="glyphicon glyphicon-plus"></span>
        Nuevo
    </a>
    <p></p>

    <table class="table table-striped table-hover">
        <tbody>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Notas</th>
                    <th>Acción</th>
                </tr>
            </thead>
            @foreach($usuarios as $usuario)
                @if($usuario->id == 1)
                    <?php continue; ?>
                @endif
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->notas }}</td>
                    <td>
                        <a href="{{ url('users/editar/'. $usuario->id) }}" class="btn btn-xs btn-warning">
                            <span class="glyphicon glyphicon-edit"></span>
                            Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $usuarios->links() }}

</div>{{-- /.container --}}

@stop