@extends('layouts.master')

@section('contenido')

<div class="container">

    <table class="table table hover table-striped table-hover">
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