@extends('tomadores.planos.layout.admin')

@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h1 class="mb-5 pt-2 titulo">Troca de Contador</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <x-alert />

                        <!-- Formulário para Troca de Contador -->
                        <form action="{{ route('tomadores.planos.storeTroca') }}" method="POST"
                            enctype="multipart/form-data" id="form-tomador">

                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label for="razao_social" class="form-label">Razão Social</label>
                                    <input type="text" class="form-control" id="razao_social" name="razao_social"
                                        value="{{ old('razao_social') }}" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="cnpj" class="form-label">CNPJ</label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj"
                                        value="{{ old('cnpj') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label for="nome_fantasia" class="form-label">Nome Fantasia</label>
                                    <input type="text" class="form-control" id="nome_fantasia"
                                        value="{{ old('nome_fantasia') }}" name="nome_fantasia">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="inscricao_municipal" class="form-label">Inscrição Municipal</label>
                                    <input type="text" class="form-control" id="inscricao_municipal"
                                        name="inscricao_municipal" value="{{ old('inscricao_municipal') }}">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="inscricao_estadual" class="form-label">Inscrição Estadual</label>
                                    <input type="text" class="form-control" id="inscricao_estadual"
                                        name="inscricao_estadual" value="{{ old('inscricao_estadual') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <h5 class="mt-4 borda">Endereço</h5>

                            <div class="row pt-2">
                                <div class="col-md-4 mb-3">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep"
                                        value="{{ old('cep') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado"
                                        value="{{ old('estado') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade"
                                        value="{{ old('cidade') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro"
                                        value="{{ old('bairro') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="logradouro" class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro" name="logradouro"
                                        value="{{ old('logradouro') }}" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero"
                                        value="{{ old('numero') }}" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="complemento" class="form-label">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento"
                                        value="{{ old('complemento') }}">
                                </div>
                            </div>

                            <input type="hidden" id="situacao" name="situacao" value="">
                            <input type="hidden" id="condicao" name="condicao" value="">

                            <h5 class="mt-4 borda">Upload de Documentos</h5>

                            <div class="row pt-2">
                                <div class="col-md-4 mb-3">
                                    <input type="file" class="form-control" id="documentos_empresa"
                                        name="documentos_empresa[]" multiple>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h3 class="mt-4">Dados dos Sócios</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4 text-right">
                                    <button type="button" class="themeBtn btn-block " id="add-socio-btn">Adicionar
                                        Sócio</button>
                                </div>
                            </div>

                            <hr />

                            <div id="socios-container">
                                <!-- Formulários Dinâmicos para Sócios serão adicionados aqui -->
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-4 pt-5 text-center">
                                    <button type="submit" class="themeBtn enviar" id="enviar">Enviar
                                        Solicitação</button>
                                </div>
                            </div>
                        </form>

                        <!-- Modal de Confirmação -->
                        <div class="modal fade" id="confirmacaoModal" tabindex="-1" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Confirmação</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Deseja confirmar o pagamento?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Não</button>
                                        <button type="button" id="btn-confirmar" class="btn btn-success">Sim</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bootstrap JS -->
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                        <!-- jQuery e jQuery Mask -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Aplicar máscara aos campos
                                $('#telefone').mask('(00) 00000-0000');
                                $('#cep').mask('00000-000');

                                // Exibir o modal ao clicar no botão enviar
                                document.querySelector('.enviar').addEventListener('click', function(event) {
                                    event.preventDefault(); // Impede o envio imediato do formulário
                                    const modal = new bootstrap.Modal(document.getElementById('confirmacaoModal'));
                                    modal.show();
                                });

                                // Confirmar o pagamento
                                document.getElementById('btn-confirmar').addEventListener('click', function() {
                                    document.getElementById('situacao').value = 'adimplente';
                                    document.getElementById('condicao').value = 'cliente regular';
                                    document.getElementById('form-tomador').submit();
                                });

                                // Recusar o pagamento
                                document.querySelector('.btn-danger').addEventListener('click', function() {
                                    document.getElementById('situacao').value = 'inadimplente';
                                    document.getElementById('condicao').value = 'abandono de carrinho';
                                    document.getElementById('form-tomador').submit();
                                });
                            });
                        </script>

                        <script>
                            let socioCount = 0;

                            // Função para aplicar máscaras
                            function applyMasks() {
                                $('.cpf').mask('000.000.000-00');
                                $('.cep').mask('00000-000');
                                $('.telefone').mask('(00) 00000-0000');
                            }

                            // Função para reorganizar os IDs após remoção de um sócio
                            function reorganizeSocios() {
                                const socios = $('#socios-container .card'); // Seleciona todos os cards de sócios
                                socioCount = 0;

                                socios.each(function(index) {
                                    socioCount++;
                                    const newId = socioCount;

                                    // Atualiza o ID do card
                                    $(this).attr('id', `socio-${newId}`);
                                    $(this).find('.card-header h5').text(`Sócio ${newId}`);
                                    $(this).find('.card-header button').attr('id', `minimize-socio-${newId}`).off('click').on('click',
                                        function() {
                                            $(`#body-socio-${newId}`).toggle();
                                        });
                                    $(this).find('.card-body').attr('id', `body-socio-${newId}`);

                                    // Atualiza IDs e Names dos inputs dentro do card
                                    $(this).find('input, label').each(function() {
                                        const originalAttr = $(this).attr('for') || $(this).attr('id') || $(this).attr('name');
                                        if (originalAttr) {
                                            const newAttr = originalAttr.replace(/\d+/,
                                                newId); // Substitui o número pelo novo ID
                                            $(this).attr('for', newAttr).attr('id', newAttr).attr('name', newAttr);
                                        }
                                    });

                                    // Atualiza o botão de remoção
                                    $(this).find('.btn-danger').off('click').on('click', function() {
                                        removeSocio(newId);
                                    });
                                });
                            }

                            // Função para remover sócio
                            function removeSocio(id) {
                                $(`#socio-${id}`).remove(); // Remove o formulário do sócio
                                reorganizeSocios(); // Reorganiza os IDs
                            }

                            $(document).ready(function() {
                                applyMasks(); // Aplicar máscaras nos campos iniciais

                                // Evento para adicionar um novo sócio
                                $('#add-socio-btn').click(function() {
                                    socioCount++;

                                    // Template para Formulário de Sócio
                                    let socioForm = `
                    <div class="card mt-4" id="socio-${socioCount}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Sócio ${socioCount}</h5>
                            <button type="button" class="btn btn-sm btn-secondary" id="minimize-socio-${socioCount}">
                                Minimizar
                            </button>
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
                                    <input type="text" class="form-control" id="identidade-${socioCount}" name="socios[${socioCount}][identidade]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cpf-${socioCount}" class="form-label">CPF</label>
                                    <input type="text" class="form-control cpf" id="cpf-${socioCount}" name="socios[${socioCount}][cpf]" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email-${socioCount}" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email-${socioCount}" name="socios[${socioCount}][email]" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefone-${socioCount}" class="form-label">Telefone</label>
                                    <input type="text" class="form-control telefone" id="telefone-${socioCount}" name="socios[${socioCount}][telefone]" required>
                                </div>
                            </div>
                            <h5 class="mt-4">Endereço</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="cep-${socioCount}" class="form-label">CEP</label>
                                    <input type="text" class="form-control cep" id="cep-${socioCount}" name="socios[${socioCount}][cep]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado-${socioCount}" class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="estado-${socioCount}" name="socios[${socioCount}][estado]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cidade-${socioCount}" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade-${socioCount}" name="socios[${socioCount}][cidade]" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="bairro-${socioCount}" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="bairro-${socioCount}" name="socios[${socioCount}][bairro]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="logradouro-${socioCount}" class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro-${socioCount}" name="socios[${socioCount}][logradouro]" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numero-${socioCount}" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero-${socioCount}" name="socios[${socioCount}][numero]" required>
                                </div>
                            </div>
                            <h5 class="mt-4">Documentos</h5>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="documentos-${socioCount}" class="form-label">Upload de Documentos</label>
                                    <input type="file" class="form-control" id="documentos-${socioCount}" name="socios[${socioCount}][documentos][]" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeSocio(${socioCount})">Remover</button>
                        </div>
                    </div>
                `;

                                    $('#socios-container').append(socioForm);
                                    applyMasks(); // Aplicar máscaras nos novos campos
                                });


                                let requestsEmAndamento = {}; // Objeto para controlar as requisições em andamento

                                $(document).on('blur', '.cep', function() {
                                    const cepInput = $(this);
                                    const socioId = cepInput.attr('id').split('-')[1];
                                    let cep = cepInput.val().replace(/\D/g, '');

                                    if (cep.length !== 8) {
                                        alert('CEP inválido. Digite um CEP com 8 dígitos.');
                                        limparCamposEndereco(socioId);
                                        return;
                                    }

                                    // Verifica se já existe uma requisição para este CEP
                                    if (requestsEmAndamento[cep]) {
                                        return; // Se sim, ignora a nova requisição
                                    }

                                    requestsEmAndamento[cep] = true; // Marca que uma requisição está em andamento para este CEP

                                    cepInput.prop('disabled', true);
                                    cepInput.addClass('carregando');
                                    $(`#cep-${socioId}`).addClass('carregando'); //adicionado para o cep do socio

                                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error(`Erro na requisição: ${response.status}`);
                                            }
                                            return response.json();
                                        })
                                        .then(data => {
                                            if (data.erro) {
                                                alert('CEP não encontrado.');
                                                limparCamposEndereco(socioId);
                                            } else {
                                                $(`#logradouro-${socioId}`).val(data.logradouro);
                                                $(`#bairro-${socioId}`).val(data.bairro);
                                                $(`#cidade-${socioId}`).val(data.localidade);
                                                $(`#estado-${socioId}`).val(data.uf);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Erro ao buscar o CEP:', error);
                                            alert('Erro ao buscar o CEP. Tente novamente mais tarde.');
                                            limparCamposEndereco(socioId);
                                        })
                                        .finally(() => {
                                            cepInput.prop('disabled', false);
                                            cepInput.removeClass('carregando');
                                            $(`#cep-${socioId}`).removeClass('carregando'); //removido para o cep do socio
                                            delete requestsEmAndamento[cep]; // Remove a marcação de requisição em andamento
                                        });
                                });

                                function limparCamposEndereco(socioId) {
                                    $(`#logradouro-${socioId}`).val('');
                                    $(`#bairro-${socioId}`).val('');
                                    $(`#cidade-${socioId}`).val('');
                                    $(`#estado-${socioId}`).val('');
                                }
                            });
                        </script>
                    @endsection
