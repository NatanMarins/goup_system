@extends('empresas.layout.admin')

@section('content')

    <h4><strong>Guias e Impostos</strong> <br /><small>{{ $tomador->nome_fantasia }}</small></h4>
    <a href="#" class="btn btn-primary btn-sm" title="enviar guia">
        <i class="fa-solid fas fa-dollar-sign btn-icon-append"></i>
    </a>

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
