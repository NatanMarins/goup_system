
@extends('empresas.layout.admin')

@section('content')


<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h4 class="fw-bold">Editar Planos</strong>
        </h4>
    </div>
</div>

<div class="row pt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">  
       
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('empresas.assinatura.update') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-success">
                                        <tr>
                                            <th>Planos</th>
                                            <th>Valor Mensal</th>
                                            <th>Valor Anual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($planos as $plano)
                                            <tr>
                                                <td class="table-secondary fw-bold">{{ $plano->planos }}</td>
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
                            </div>

                            <div class="row">
                                <div class="col-md-12 mt-3 text-center">
                                    <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
                                </div>
                            </div>
                            
                        </form>

                                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
