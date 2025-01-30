@extends('empresas.layout.admin')

@section('content')

    <x-alert />

    <div class="container mt-5">
        <h2>Lista de Cupons</h2>
        <button class="btn btn-primary mb-3" onclick="abrirModalCadastro()">Cadastrar Novo Cupom</button>

        @if ($cupons->isEmpty())
            <div class="alert alert-warning" role="alert">
                <p>Nenhum Cupon Cadastrado!</p>
            </div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Percentual</th>
                        <th>Ações</th>
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
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

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
                        <label>Código:</label>
                        <input type="text" name="codigo" id="codigo" class="form-control">
                        <label>Percentual:</label>
                        <input type="number" name="percentual" id="percentual" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <button class="btn btn-secondary" onclick="fecharModal('modalCadastro')">Fechar</button>
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
@endsection
