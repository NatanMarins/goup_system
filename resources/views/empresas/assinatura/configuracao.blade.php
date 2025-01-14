@extends('empresas.layout.admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">Editar Planos</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('empresas.assinatura.update') }}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Plano</th>
                        <th>Valor Mensal</th>
                        <th>Valor Anual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planos as $plano)
                        <tr>
                            <td>{{ $plano->planos }}</td>
                            <td>
                                <input type="number" step="0.01" name="planos[{{ $plano->id }}][valor_mensal]"
                                    value="{{ $plano->valor_mensal }}" class="form-control">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="planos[{{ $plano->id }}][valor_anual]"
                                    value="{{ $plano->valor_anual }}" class="form-control">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        </form>
    </div>
@endsection
