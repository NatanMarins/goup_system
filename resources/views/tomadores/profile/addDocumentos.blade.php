@extends('tomadores.layout.admin')

@section('content')
    <style>
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            position: relative;
        }

        .popup-content h5 {
            margin-bottom: 20px;
        }

        .upload-area {
            border: 2px dashed #ccc;
            padding: 20px;
            border-radius: 8px;
            background: #f9f9f9;
            cursor: pointer;
        }

        .upload-area.dragover {
            background: #e0f7fa;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            color: #999;
        }

        .file-list {
            margin-top: 20px;
            text-align: left;
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .file-list p {
            margin: 5px 0;
        }
    </style>

    <div class="container">
        <h3>Envio de Documentos</h3>
        <button class="btn btn-primary" data-popup="identidadePopup">Identidade</button>
        <button class="btn btn-primary" data-popup="cpfPopup">CPF</button>
        <button class="btn btn-primary" data-popup="comprovantePopup">Comprovante de Residência</button>
    </div>

    <!-- Popup Template -->
    <div class="popup-overlay" id="identidadePopup">
        <div class="popup-content">
            <span class="close-btn" data-close>&times;</span>
            <h5>Enviar Identidade</h5>
            <div class="upload-area" id="uploadIdentidade">Arraste o arquivo ou clique aqui para selecionar</div>
            <div class="file-list" id="fileListIdentidade"></div>
            <button class="btn btn-primary" id="submitIdentidade">Enviar Arquivos</button>
        </div>
    </div>

    <div class="popup-overlay" id="cpfPopup">
        <div class="popup-content">
            <span class="close-btn" data-close>&times;</span>
            <h5>Enviar CPF</h5>
            <div class="upload-area" id="uploadCpf">Arraste o arquivo ou clique aqui para selecionar</div>
            <div class="file-list" id="fileListCpf"></div>
            <button class="btn btn-primary" id="submitCpf">Enviar Arquivos</button>
        </div>
    </div>

    <div class="popup-overlay" id="comprovantePopup">
        <div class="popup-content">
            <span class="close-btn" data-close>&times;</span>
            <h5>Enviar Comprovante de Residência</h5>
            <div class="upload-area" id="uploadComprovante">Arraste o arquivo ou clique aqui para selecionar</div>
            <div class="file-list" id="fileListComprovante"></div>
            <button class="btn btn-primary" id="submitComprovante">Enviar Arquivos</button>
        </div>
    </div>

    <script>
        const setupPopup = (uploadAreaId, fileListId, submitButtonId, endpoint) => {
            const uploadArea = document.getElementById(uploadAreaId);
            const fileList = document.getElementById(fileListId);
            const submitButton = document.getElementById(submitButtonId);
            let files = [];

            // Exibir arquivos na lista
            const updateFileList = () => {
                fileList.innerHTML = '';
                files.forEach((file, index) => {
                    const fileElement = document.createElement('p');
                    fileElement.textContent = `${index + 1}. ${file.name}`;
                    fileList.appendChild(fileElement);
                });
            };

            // Drag-and-drop funcionalidade
            uploadArea.addEventListener('dragover', (event) => {
                event.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', (event) => {
                event.preventDefault();
                uploadArea.classList.remove('dragover');
                files = Array.from(event.dataTransfer.files);
                updateFileList();
            });

            // Click para selecionar arquivos
            uploadArea.addEventListener('click', () => {
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.multiple = true;
                fileInput.click();

                fileInput.addEventListener('change', () => {
                    files = Array.from(fileInput.files);
                    updateFileList();
                });
            });

            // Enviar arquivos para o backend
            submitButton.addEventListener('click', async () => {
                if (files.length === 0) {
                    alert('Nenhum arquivo selecionado!');
                    return;
                }

                const formData = new FormData();
                files.forEach((file) => {
                    formData.append('files[]', file);
                });

                try {
                    const response = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                        },
                        body: formData,
                    });

                    if (response.ok) {
                        alert('Arquivos enviados com sucesso!');
                        files = [];
                        updateFileList();
                    } else {
                        const errorData = await response.json();
                        alert('Erro ao enviar arquivos: ' + errorData.message);
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    alert('Erro inesperado ao enviar os arquivos.');
                }
            });
        };

        // Configurar popups
        setupPopup('uploadIdentidade', 'fileListIdentidade', 'submitIdentidade', '/upload/identidade');
        setupPopup('uploadCpf', 'fileListCpf', 'submitCpf', '/upload/cpf');
        setupPopup('uploadComprovante', 'fileListComprovante', 'submitComprovante', '/upload/comprovante');

        // Abrir e fechar popups
        document.querySelectorAll('[data-popup]').forEach((button) => {
            button.addEventListener('click', () => {
                const popupId = button.getAttribute('data-popup');
                document.getElementById(popupId).style.display = 'flex';
            });
        });

        document.querySelectorAll('[data-close]').forEach((closeBtn) => {
            closeBtn.addEventListener('click', () => {
                closeBtn.closest('.popup-overlay').style.display = 'none';
            });
        });
    </script>
@endsection
