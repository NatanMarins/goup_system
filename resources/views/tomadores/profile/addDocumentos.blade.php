@extends('tomadores.layout.admin')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

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

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>

    <h2>Envio de Documentos</h2>

    <form id="uploadForm" action="{{ route('tomadores.profile.storeDocumentos') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('POST')

        <!-- Contrato Social -->
        <div class="upload-container">
            <label>Contrato Social:</label>
            <div class="file-drop-zone" data-field="contrato_social">
                Arraste e solte os arquivos aqui ou clique para selecionar.
                <input type="file" name="contrato_social[]" multiple hidden>
            </div>
            <ul class="file-names" id="contrato_social_files"></ul>
        </div>

        <!-- Alvará de Funcionamento -->
        <div class="upload-container">
            <label>Alvará de Funcionamento:</label>
            <div class="file-drop-zone" data-field="alvara_funcionamento">
                Arraste e solte os arquivos aqui ou clique para selecionar.
                <input type="file" name="alvara_funcionamento[]" multiple hidden>
            </div>
            <ul class="file-names" id="alvara_funcionamento_files"></ul>
        </div>

        <!-- Inscrição Estadual -->
        <div class="upload-container">
            <label>Inscrição Estadual:</label>
            <div class="file-drop-zone" data-field="inscricao_estadual">
                Arraste e solte os arquivos aqui ou clique para selecionar.
                <input type="file" name="inscricao_estadual[]" multiple hidden>
            </div>
            <ul class="file-names" id="inscricao_estadual_files"></ul>
        </div>

        <!-- Botão de envio -->
        <button type="submit">Enviar Documentos</button>
    </form>

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
