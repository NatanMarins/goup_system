
@extends('empresas.layout.admin')

@section('content')

 <!-- Cabeçalho -->
 <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h4><strong>Documentos</strong> <br /><small>{{ $tomador->nome_fantasia }}</small></h4>
    </div>
    <!-- botao -->
    <div class="ms-md-auto py-2 py-md-0">
        <div class="btn-group" role="group" aria-label="Basic example">
            <!-- botao voltar -->
            <a href="{{ route('empresas.tomador.show', ['tomadorservico' => $tomador->id]) }}" class="btn btn btn-primary btn-sm" title="Voltar">
                <i class="fa-solid fa-arrow-left btn-icon-append"></i> 
            </a>
            <!-- botao voltar -->
            <a href="#" class="btn btn btn-primary btn-sm" title="Dados de Pagamento">
                <i class="fa-solid fas fa-dollar-sign btn-icon-append"></i>
            </a>

        </div>
    </div>
    <!-- botao -->
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
                                        <th scope="col"  class="fw-bold ">Descrição</th>
                                        <th scope="col"  class="fw-bold">Size</th>
                                        <th scope="col"  class="fw-bold">Última modificação</th>
                                        <th scope="col" style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody class="files-table-row">
                                    @forelse($documentos as $documento)
                                        <tr>
                                            <td class=""> <i class="fa-solid fas fa-file-alt" style='font-size:25px; color:#01c592;'></i></td>
                                            <td> {{ $documento->descricao }}</td>
                                            <td> 42 MB</td>
                                            <td> 10/10/2024</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $documento->path) }}" target="_blank"  class="btn btn btn-primary btn-sm" title="Baixar">
                                                    <i class="fa-solid fas fa-download btn-icon-append"></i>
                                                </a>
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

<div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Formulário de Upload -->
                        <h4>Fazer Upload de Novos Documentos</h4>
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group pt-3">
                                <label for="documentos">Selecionar Documentos</label>
                                <input type="file" name="documentos[]" class="form-control @error('documentos') is-invalid @enderror"   multiple required>
                                @error('documentos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Enviar Documentos</button>
                        </form>
                        <!-- Formulário de Upload -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
@endsection






  