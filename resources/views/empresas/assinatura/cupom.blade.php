@extends('empresas.layout.admin')

@section('content')

    <x-alert />

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h4 class="fw-bold">Lista de Cupons</strong>
            </h4>
        </div>
    </div>

    <div class="row pt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">  
 
                            <button class="btn btn-primary mb-3" onclick="abrirModalCadastro()">Cadastrar Novo Cupom</button>

                            @if ($cupons->isEmpty())
                                <div class="alert alert-warning" role="alert">
                                    <p>Nenhum Cupon Cadastrado!</p>
                                </div>
                            @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-success">
                                        <tr>
                                            <th>Código</th>
                                            <th>Percentual</th>
                                            <th style="width: 5%"></th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cupons as $cupom)
                                            <tr>
                                                <td>{{ $cupom->codigo }}</td>
                                                <td>{{ $cupom->percentual }}%</td>
                                                <td>
                                                    <form action="{{ route('empresas.assinatura.deleteCupom', $cupom->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Excluir"><i class="fa-solid fa-close"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        

                        <!-- Modal Cadastro -->
                        <div class="modal" id="modalCadastro">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cadastrar Cupom</h5>
                                        <button type="button" class="btn-close" onclick="fecharModal('modalCadastro')"></button>
                                    </div>
                                    <form action="{{ route('empresas.assinatura.storeCupom') }}" method="POST">
                                        @csrf
                                        @method('POST')

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Código:</label>
                                                        <input type="text" name="codigo" class="form-control" id="codigo" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Percentual:</label>
                                                        <input type="number" name="percentual" class="form-control" id="percentual" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                                <div class="col-md-12 text-center">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-danger btn-sm">Salvar</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                            function abrirModalCadastro() {
                                document.getElementById('modalCadastro').style.display = 'block';
                            }

                            function fecharModal(id) {
                                document.getElementById(id).style.display = 'none';
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
