@extends('tomadores.layout.admin')

@section('content')
<div class="container mt-5">
    <h2>Guias e Impostos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Vencimento</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guias as $guia)
                <tr>
                    <td>{{ $guia->descricao }}</td>
                    <td>{{ $guia->valor }}</td>
                    <td>{{ $guia->vencimento }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info">Visualizar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
