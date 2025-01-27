@extends('empresas.layout.admin')

@section('content')


<!-- Cabeçalho -->
<div class="d-flex bd-highlight pt-2 pb-2">
    <div class="p-2 flex-grow-1 bd-highlight">
        <h4><strong>Documentos do Sócio</strong> <br /><small>{{ $socio->nome }}</h4>
    </div>
    <div class="p-2 bd-highlight">
        <!-- botao -->
        <div class="ms-md-auto py-2 py-md-0 text-left">
            <div class="btn-group" role="group" aria-label="Basic example">
                <!-- botao voltar -->
                <a href="{{ route('empresas.tomador.show', $tomadorId) }}" class="btn btn btn-primary btn-sm" title="Voltar">
                    <i class="fa-solid fa-arrow-left btn-icon-append"></i> 
                </a>
                <!-- botao Pagamento -->
                <a href="" class="btn btn btn-primary btn-sm" title="Dados de Pagamento">
                    <i class="fa-solid fas fa-dollar-sign btn-icon-append"></i>
                </a>

            </div>
        </div>
        <!-- botao -->
    </div>
</div>
<!-- Cabeçalho -->

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!--tabela -->
                        <div class="table-responsive">
                            <table class="table mt-3">
                                <thead>
                                    <tr>	
                                        <th scope="col"  style="width: 5%"> </th>
                                        <th scope="col"  class="fw-bold">Tipo</th>
                                        <th scope="col"  class="fw-bold">Descrição</th>
                                        <th scope="col" style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody class="files-table-row">
                                    @forelse($documentos as $documento)
                                        <tr>
                                            <td class=""> <i class="fa-solid fas fa-file-alt" style='font-size:20px; color:#01c592;'></i></td>
                                            <td> {{ $documento->tipo }}</td>
                                            <td> {{ $documento->descricao }}</td>
                                            
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{ asset('storage/' . $documento->caminho) }}" target="_blank"  class="btn btn-primary btn-sm" title="Baixar">
                                                        <i class="fa-solid fas fa-download btn-icon-append"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Nenhum documento encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!--tabela -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
