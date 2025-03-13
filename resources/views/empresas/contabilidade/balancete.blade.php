@extends('empresas.layout.admin')

@section('content')
    <div class="container">
        <h1>Gerar Balancete</h1>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('empresas.contabilidade.gerarBalancete', $tomadorservico) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="mes">Mês:</label>
                <select name="mes" id="mes" class="form-control" required>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label for="ano">Ano:</label>
                <select name="ano" id="ano" class="form-control" required>
                    @for ($i = date('Y'); $i >= 2000; $i--)
                        <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Gerar</button>
        </form>
    </div>
@endsection
