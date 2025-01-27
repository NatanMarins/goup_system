@extends('empresas.layout.admin')

@section('content')
    <style>
        .upload-container {
            margin-bottom: 20px;
        }

        .file-drop-zone {
            border: 2px dashed #aaa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            color: #555;
            transition: 0.2s;
        }

        .file-drop-zone:hover {
            background-color: #f8f8f8;
        }

        .file-names {
            margin-top: 10px;
            list-style: none;
            padding: 0;
        }

        .file-names li {
            margin-bottom: 5px;
        }

        .file-names li.invalid {
            color: red;
        }
    </style>

    <x-alert />

    <!-- Cabeçalho -->
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-3">
        <div>
            <h4><strong>Documentos</strong> <br /><small>{{ $tomador->nome_fantasia }}</small></h4>
        </div>
        <!-- botao -->
        <div class="ms-md-auto py-2 py-md-0">
            <div class="btn-group" role="group" aria-label="Basic example">
                <!-- botao voltar -->
                <a href="{{ route('empresas.tomador.show', ['tomadorservico' => $tomador->id]) }}"
                    class="btn btn-primary btn-sm" title="Voltar">
                    <i class="fa-solid fa-arrow-left btn-icon-append"></i>
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
                                            <th scope="col" style="width: 5%"> </th>
                                            <th scope="col" class="fw-bold">Tipo</th>
                                            <th scope="col" class="fw-bold ">Descrição</th>
                                            <th scope="col" style="width: 5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="files-table-row">
                                        @forelse($tomador->documentos as $documento)
                                            <tr>
                                                <td class="">
                                                    <i class="fa-solid fas fa-file-alt"
                                                        style='font-size:20px; color:#01c592;'></i>
                                                </td>
                                                <td> {{ $documento->tipo }}</td>
                                                <td> {{ $documento->descricao }}</td>

                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{ asset('storage/' . $documento->path) }}" target="_blank"
                                                            class="btn btn-primary btn-sm" title="Baixar">
                                                            <i class="fa-solid fas fa-download btn-icon-append"></i>
                                                        </a>
                                                        <!-- Botão de Exclusão -->
                                                        <form
                                                            action="{{ route('empresas.tomador.documentosDestroy', $documento->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Tem certeza que deseja excluir este documento?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary btn-sm"
                                                                title="Excluir">
                                                                <i class="fa-solid fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                        <!-- Botão de Exclusão -->
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

    <div class="row">
        <div class="col-sm-12">
            <div>
                <h4><strong>Upload</strong> <br /><small>Fazer Upload de Novos Documentos</small></h4>
            </div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Formulário de Upload -->
                            <form id="uploadForm" action="{{ route('empresas.tomador.storeDocumentos', $tomador->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- Contrato Social -->
                                        <div class="upload-container">
                                            <label>Contrato Social:</label>
                                            <div class="file-drop-zone" data-field="contrato_social">
                                                Arraste e solte os arquivos aqui ou clique para selecionar.
                                                <input type="file" name="contrato_social[]" multiple hidden>
                                            </div>
                                            <ul class="file-names" id="contrato_social_files"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Alvará de Funcionamento -->
                                        <div class="upload-container">
                                            <label>Alvará de Funcionamento:</label>
                                            <div class="file-drop-zone" data-field="alvara_funcionamento">
                                                Arraste e solte os arquivos aqui ou clique para selecionar.
                                                <input type="file" name="alvara_funcionamento[]" multiple hidden>
                                            </div>
                                            <ul class="file-names" id="alvara_funcionamento_files"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Inscrição Estadual -->
                                        <div class="upload-container">
                                            <label>Inscrição Estadual:</label>
                                            <div class="file-drop-zone" data-field="inscricao_estadual">
                                                Arraste e solte os arquivos aqui ou clique para selecionar.
                                                <input type="file" name="inscricao_estadual[]" multiple hidden>
                                            </div>
                                            <ul class="file-names" id="inscricao_estadual_files"></ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <!-- Botão de envio -->
                                        <button type="submit" class="btn btn-primary">Enviar Documentos</button>
                                    </div>
                                </div>

                            </form>
                            <!-- Formulário de Upload -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Configuração: tipos de arquivos permitidos
        const allowedFileTypes = ['application/pdf', 'image/jpeg', 'image/png'];

        // Manipular zonas de arrastar e soltar
        const dropZones = document.querySelectorAll('.file-drop-zone');

        dropZones.forEach(zone => {
            const input = zone.querySelector('input');
            const fileList = document.getElementById(`${zone.dataset.field}_files`);
            const allFiles = new DataTransfer(); // Armazena todos os arquivos selecionados no campo

            // Abrir seletor de arquivos ao clicar na zona
            zone.addEventListener('click', () => input.click());

            // Adicionar arquivos ao soltar
            zone.addEventListener('dragover', e => {
                e.preventDefault();
                zone.style.backgroundColor = '#f8f8f8';
            });

            zone.addEventListener('dragleave', () => {
                zone.style.backgroundColor = 'white';
            });

            zone.addEventListener('drop', e => {
                e.preventDefault();
                zone.style.backgroundColor = 'white';
                handleFiles(e.dataTransfer.files, input, fileList, allFiles);
            });

            // Adicionar arquivos ao selecionar
            input.addEventListener('change', () => {
                handleFiles(input.files, input, fileList, allFiles);
            });
        });

        // Função para processar arquivos
        function handleFiles(files, input, fileList, allFiles) {
            Array.from(files).forEach(file => {
                const listItem = document.createElement('li');
                listItem.textContent = file.name;

                if (allowedFileTypes.includes(file.type)) {
                    allFiles.items.add(file); // Adicionar ao DataTransfer global
                    listItem.classList.add('valid');
                } else {
                    listItem.classList.add('invalid');
                    listItem.textContent += ' - Tipo de arquivo inválido!';
                }

                fileList.appendChild(listItem); // Adicionar à lista visível
            });

            // Atualizar input com todos os arquivos acumulados
            input.files = allFiles.files;
        }
    </script>
@endsection
