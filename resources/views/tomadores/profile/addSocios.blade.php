@extends('tomadores.layout.admin')

@section('content')
    <style>
        .upload-area {
            border: 2px dashed #007bff;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #f8f9fa;
            color: #6c757d;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .upload-area:hover {
            background-color: #e2e6ea;
        }

        .file-list {
            margin-top: 10px;
            padding: 0;
            list-style-type: none;
        }

        .file-list li {
            background: #f1f1f1;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 3px;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>

    <x-alert />

    <div class="container">
        <h2>Cadastro de Sócios</h2>

        <!-- Pergunta Quantos Sócios Deseja Cadastrar -->
        <div class="mb-4">
            <label for="numeroSocios" class="form-label">Quantos sócios deseja cadastrar?</label>
            <input type="number" id="numeroSocios" class="form-control" min="1" placeholder="Insira o número de sócios">
            <button class="btn btn-primary mt-3" id="gerarFormularios">Gerar Formulários</button>
        </div>

        <!-- Formulários Gerados Dinamicamente -->
        <form action="{{ route('tomadores.profile.storeSocios') }}" method="POST" id="sociosForm" style="display: none;" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div id="formulariosSocios"></div>

            <!-- Botão Salvar Sócios -->
            <div class="mt-4">
                <button type="submit" class="btn btn-success" id="salvarSocios">Salvar Sócios</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Função para aplicar máscaras
            const aplicarMascaras = () => {
                $('.telefone').mask('(00) 00000-0000');
                $('.cpf').mask('000.000.000-00');
                $('.cep').mask('00000-000');
                $('.identidade').mask('000.000.000-0'); // Identidade
            };

            // Aplicar máscaras ao carregar a página
            aplicarMascaras();

            // Delegar evento de blur para os campos de CEP gerados dinamicamente
            $(document).on('blur', '.cep', function() {
                const cepInput = $(this);
                const cep = cepInput.val().replace(/\D/g, ''); // Remove caracteres não numéricos

                if (cep.length !== 8) {
                    alert('CEP inválido. Digite um CEP com 8 números.');
                    limparCamposEndereco(cepInput); // Limpa os campos relacionados
                    return;
                }

                // Requisição para a API ViaCEP
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Erro na requisição: Status ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.erro) {
                            alert('CEP não encontrado.');
                            limparCamposEndereco(cepInput);
                        } else {
                            const cardBody = cepInput.closest('.card-body');
                            cardBody.find('[id^="logradouro"]').val(data.logradouro || '');
                            cardBody.find('[id^="bairro"]').val(data.bairro || '');
                            cardBody.find('[id^="cidade"]').val(data.localidade || '');
                            cardBody.find('[id^="estado"]').val(data.uf || '');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar o CEP:', error);
                        alert('Erro ao buscar o CEP. Verifique sua conexão e tente novamente.');
                        limparCamposEndereco(cepInput);
                    });
            });

            // Função para limpar os campos relacionados ao endereço
            const limparCamposEndereco = (cepInput) => {
                const cardBody = cepInput.closest('.card-body');
                cardBody.find('[id^="logradouro"]').val('');
                cardBody.find('[id^="bairro"]').val('');
                cardBody.find('[id^="cidade"]').val('');
                cardBody.find('[id^="estado"]').val('');
            };

            // Gerar formulários dinamicamente
            document.getElementById('gerarFormularios').addEventListener('click', () => {
                const numeroSocios = document.getElementById('numeroSocios').value;
                const formulariosContainer = document.getElementById('formulariosSocios');
                const sociosForm = document.getElementById('sociosForm');

                formulariosContainer.innerHTML = ''; // Limpar os formulários anteriores

                if (numeroSocios > 0) {
                    sociosForm.style.display = 'block'; // Mostrar o formulário principal
                    for (let socioCount = 1; socioCount <= numeroSocios; socioCount++) {
                        formulariosContainer.innerHTML += `
                        <div class="card mt-4" id="socio-${socioCount}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Sócio ${socioCount}</h5>
                        </div>
                        <div class="card-body" id="body-socio-${socioCount}">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="nome-${socioCount}" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome-${socioCount}" name="socios[${socioCount}][nome]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado_civil-${socioCount}" class="form-label">Estado Civil</label>
                                    <input type="text" class="form-control" id="estado_civil-${socioCount}" name="socios[${socioCount}][estado_civil]" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="profissao-${socioCount}" class="form-label">Profissão</label>
                                    <input type="text" class="form-control" id="profissao-${socioCount}" name="socios[${socioCount}][profissao]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="identidade-${socioCount}" class="form-label">Identidade</label>
                                    <input type="text" class="form-control identidade" id="identidade-${socioCount}" name="socios[${socioCount}][identidade]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cpf-${socioCount}" class="form-label">CPF</label>
                                    <input type="text" class="form-control cpf" id="cpf-${socioCount}" name="socios[${socioCount}][cpf]" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="email-${socioCount}" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email-${socioCount}" name="socios[${socioCount}][email]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="telefone-${socioCount}" class="form-label">Telefone</label>
                                    <input type="text" class="form-control telefone" id="telefone-${socioCount}" name="socios[${socioCount}][telefone]" required>
                                </div>
                            </div>
                            <h5 class="mt-4">Endereço</h5>
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label for="cep-${socioCount}" class="form-label">CEP</label>
                                    <input type="text" class="form-control cep" id="cep-${socioCount}" name="socios[${socioCount}][cep]" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="estado-${socioCount}" class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="estado-${socioCount}" name="socios[${socioCount}][estado]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cidade-${socioCount}" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade-${socioCount}" name="socios[${socioCount}][cidade]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="bairro-${socioCount}" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="bairro-${socioCount}" name="socios[${socioCount}][bairro]" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 mb-3">
                                    <label for="logradouro-${socioCount}" class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro-${socioCount}" name="socios[${socioCount}][logradouro]" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="numero-${socioCount}" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero-${socioCount}" name="socios[${socioCount}][numero]" required>
                                </div>
                            </div>
                            <h5 class="mt-4">Documentos</h5>
                            <div class="row">
                                <!-- Campo Identidade -->
                                <div class="col-md-12 mb-3">
                                    <label for="identidade-${socioCount}" class="form-label">Identidade</label>
                                    <div class="upload-area" id="upload-identidade-${socioCount}" onclick="triggerFileInput('input-identidade-${socioCount}')">
                                        <p>Clique para selecionar o arquivo</p>
                                        <input type="file" id="input-identidade-${socioCount}" name="socios[${socioCount}][documentos][identidade][]" multiple accept=".jpg,.jpeg,.png,.pdf" onchange="handleFileSelect(event, 'identidade-${socioCount}')" hidden>
                                    </div>
                                    <ul class="file-list" id="file-list-identidade-${socioCount}"></ul>
                                </div>

                                <!-- Campo CPF -->
                                <div class="col-md-12 mb-3">
                                    <label for="cpf-${socioCount}" class="form-label">CPF</label>
                                    <div class="upload-area" id="upload-cpf-${socioCount}" onclick="triggerFileInput('input-cpf-${socioCount}')">
                                        <p>Clique para selecionar o arquivo</p>
                                        <input type="file" id="input-cpf-${socioCount}" name="socios[${socioCount}][documentos][cpf][]" multiple accept=".jpg,.jpeg,.png,.pdf" onchange="handleFileSelect(event, 'cpf-${socioCount}')" hidden>
                                    </div>
                                    <ul class="file-list" id="file-list-cpf-${socioCount}"></ul>
                                </div>

                                <!-- Campo Comprovante de Residência -->
                                <div class="col-md-12 mb-3">
                                    <label for="comprovante-${socioCount}" class="form-label">Comprovante de Residência</label>
                                    <div class="upload-area" id="upload-comprovante-${socioCount}" onclick="triggerFileInput('input-comprovante-${socioCount}')">
                                        <p>Clique para selecionar o arquivo</p>
                                        <input type="file" id="input-comprovante-${socioCount}" name="socios[${socioCount}][documentos][comprovante][]" multiple accept=".jpg,.jpeg,.png,.pdf" onchange="handleFileSelect(event, 'comprovante-${socioCount}')" hidden>
                                    </div>
                                    <ul class="file-list" id="file-list-comprovante-${socioCount}"></ul>
                                </div>

                                <!-- Campo Espelho IPTU Endereço da Empresa -->
                                <div class="col-md-12 mb-3">
                                    <label for="iptu-${socioCount}" class="form-label">Espelho IPTU (Endereço da Empresa)</label>
                                    <div class="upload-area" id="upload-iptu-${socioCount}" onclick="triggerFileInput('input-iptu-${socioCount}')">
                                        <p>Clique para selecionar o arquivo</p>
                                        <input type="file" id="input-iptu-${socioCount}" name="socios[${socioCount}][documentos][iptu][]" multiple accept=".jpg,.jpeg,.png,.pdf" onchange="handleFileSelect(event, 'iptu-${socioCount}')" hidden>
                                    </div>
                                    <ul class="file-list" id="file-list-iptu-${socioCount}"></ul>
                                </div>
                            </div>`;
                    }

                    // Reaplicar máscaras após a geração dos formulários
                    aplicarMascaras();
                } else {
                    sociosForm.style.display = 'none'; // Ocultar o formulário principal
                    alert('Por favor, insira um número válido de sócios.');
                }
            });
        });
    </script>

    <script>
        function triggerFileInput(inputId) {
            document.getElementById(inputId).click();
        }

        function handleFileSelect(event, id) {
            const files = event.target.files;
            updateFileList(files, id);
        }

        function updateFileList(files, id) {
            const fileList = document.getElementById(`file-list-${id}`);
            fileList.innerHTML = '';

            Array.from(files).forEach(file => {
                if (!['image/jpeg', 'image/png', 'application/pdf'].includes(file.type)) {
                    alert(`Arquivo "${file.name}" não é válido. Apenas JPG, PNG ou PDF são permitidos.`);
                    return;
                }

                const listItem = document.createElement('li');
                listItem.textContent = file.name;

                fileList.appendChild(listItem);
            });
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
@endsection
