@extends('tomadores.planos.layout.admin')

@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        .pricing-container {
            display: flex;
            gap: 20px;
            align-items: flex-end;
        }

        .pricing-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
            width: 320px;
            border: 1px solid #d4edda;
            cursor: pointer;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .featured {
            transform: translateY(-30px);
            border: 2px solid #22856A;
            background: linear-gradient(135deg, #e8f5e9, #ffffff);
        }

        .featured:hover {
            transform: translateY(-40px);
        }

        .pricing-card.selected {
            border-color: #22856A;
            transform: translateY(-15px) scale(1.05);
        }

        /* Typography */
        h3 {
            margin: 0;
            font-size: 24px;
            color: #22856A;
        }

        .price {
            font-size: 36px;
            margin: 10px 0;
            color: #01464d;
        }

        /* List Styles */
        ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        ul li {
            margin: 10px 0;
            color: #555;
        }
    </style>

    <div class="container mt-5 mb-5">
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

                                <div class="col-md-4 mb-2">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone"
                                        value="{{ old('telefone') }}" required>
                                </div>
                            </div>

                            <h5 class="mt-4 borda">Endereço</h5>

                            <div class="row pt-2">
                                <div class="col-md-2 mb-3">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep"
                                        value="{{ old('cep') }}" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado"
                                        value="{{ old('estado') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade"
                                        value="{{ old('cidade') }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro"
                                        value="{{ old('bairro') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-3">
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
                                <div class="col-8 align-self-start">
                                    <h5 class="mt-4 borda">Dados dos Sócios</h5>
                                </div>

                                <div class="col-4 align-self-end text-right">
                                    <button type="button" class="themeBtn btn-block" id="add-socio-btn">Adicionar
                                        Sócio</button>
                                </div>
                            </div>

                            <hr />

                            <div id="socios-container">
                                <!-- Formulários Dinâmicos para Sócios serão adicionados aqui -->
                            </div>

                            <!-- Escolha de Plano e pagamento -->
                            <h5 class="mt-4 borda">Escolha de Plano</h5>
                            <div class="row">
                                <div class="col-md-12 mb-3">

                                    <div class="pricing-container pt-5">
                                        <div class="pricing-card" onclick="selectCard(this)">
                                            <h3 class="pb-2">Empreendedor</h3>
                                            <small>Simples Nacional</small>
                                            <p>Ideal para o empreendedor que está começando e busca os serviços básicos de
                                                contabilidade digital para manter sua empresa em dia.</p>
                                            <p class="price">R$ {{ $empreendedorMensal }}</p>
                                            <p><small>Valor Anual: R$ {{ $empreendedorAnual }}</small></p>
                                            <ul>
                                                <li>Abertura de Empresa Grátis*</li>
                                                <li>Atendimento Telefônico</li>
                                                <li>Emissão de Boleto</li>
                                            </ul>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="plano"
                                                    value="empreendedor" id="empreendedor">
                                                <label class="form-check-label" for="empreendedor">
                                                    Selecionar
                                                </label>
                                            </div>
                                        </div>

                                        <div class="pricing-card featured" onclick="selectCard(this)">
                                            <h3 class="pb-2">Visionário</h3>
                                            <small>Simples Nacional</small>
                                            <p>Ideal para empresas que estão em crescimento e buscam uma contabilidade que
                                                ajude a dar mais visão estratégica e controle financeiro, sem perder
                                                simplicidade.</p>
                                            <p class="price">R$ {{ $visionarioMensal }}</p>
                                            <p><small>Valor Anual: R$ {{ $visionarioAnual }}</small></p>
                                            <ul>
                                                <li>Abertura de Empresa Grátis*</li>
                                                <li>Atendimento Telefônico</li>
                                                <li>Emissão de Boleto</li>
                                            </ul>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="plano"
                                                    value="visionario" id="visionario">
                                                <label class="form-check-label" for="visionario">
                                                    Selecionar
                                                </label>
                                            </div>
                                        </div>

                                        <div class="pricing-card" onclick="selectCard(this)">
                                            <h3 class="pb-2">Líder</h3>
                                            <small>Simples Nacional</small>
                                            <p>Oferece todos os recursos e serviços possíveis, adequado ao empreendedor que
                                                quer otimizar todos os processos contábeis e focar no crescimento e sucesso
                                                do seu negócio.</p>
                                            <p class="price">R$ {{ $liderMensal }}</p>
                                            <p><small>Valor Anual: R$ {{ $liderAnual }}</small></p>
                                            <ul>
                                                <li>Abertura de Empresa Grátis*</li>
                                                <li>Atendimento Telefônico</li>
                                                <li>Emissão de Boleto</li>
                                            </ul>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="plano"
                                                    value="lider" id="lider">
                                                <label class="form-check-label" for="lider">
                                                    Selecionar
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Escolha de Plano e pagamento -->
                            <h5 class="mt-4 borda">Pagamento</h5>

                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label for="billingType" class="form-label">Forma de Pagamento</label>
                                    <select name="billingType" id="billingType" class="form-select" required>
                                        <option value="BOLETO">Boleto</option>
                                        <option value="CREDIT_CARD">Cartão de Crédito</option>
                                        <option value="PIX">PIX</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label for="cycle" class="form-label">Ciclo</label>
                                    <select name="cycle" id="cycle" class="form-select" required>
                                        <option value="YEARLY">Anual</option>
                                        <option value="MONTHLY">Mensal</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Politicas -->
                            <h5 class="mt-4 borda">Diretrizes</h5>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <a href="https://www.dinerb.com.br/goup/politica-de-privacidade/" target="_blank"
                                            type="button" class="btn btn-outline-secondary">Política de Privacidade</a>
                                        <a href="https://www.dinerb.com.br/goup/termo-de-uso/" type="button"
                                            target="_blank" class="btn btn-outline-secondary">Termos e Condições de
                                            Uso</a>
                                    </div>
                                </div>
                            </div>
                            <p><small><i>* Ao continuar, você declara que leu e concorda com os Termos de Uso e a Política
                                        de Privacidade.</i></small></p>

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
                                        Deseja confirmar Operação?
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
