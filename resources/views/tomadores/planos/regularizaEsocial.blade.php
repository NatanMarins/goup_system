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

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h1 class="mb-5 pt-2 titulo">Regulariza eSocial</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <x-alert />

                        <!-- Formulário de Abertura de Empresa -->
                        <form action="{{ route('tomadores.planos.storeEsocial') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        value="{{ old('nome') }}" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="sobrenome" class="form-label">Sobrenome</label>
                                    <input type="text" class="form-control" id="sobrenome" name="sobrenome"
                                        value="{{ old('sobrenome') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="email" class="form-label">E-Mail</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone"
                                        value="{{ old('telefone') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="cpf_responsavel" class="form-label">CPF</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf_responsavel"
                                        value="{{ old('cpf_responsavel') }}" required>
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

                            <!-- Plano e pagamento -->
                            <h5 class="mt-4 borda">Meu Plano</h5>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="pricing-container pt-5">
                                        <div class="pricing-card">
                                            <h3 class="pb-2">Plano E-Social</h3>
                                            <small>E-Social</small>
                                            <p>Ideal para o empreendedor que está começando e busca os serviços básicos de
                                                contabilidade digital para manter sua empresa em dia.</p>
                                            <p class="price">R$ {{ $esocialMensal }}</p>
                                            <p><small>Valor Anual: R$ {{ $esocialAnual }}</small></p>
                                            <ul>
                                                <li>Abertura de Empresa Grátis*</li>
                                                <li>Atendimento Telefônico</li>
                                                <li>Emissão de Boleto</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Plano e pagamento -->

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

                                <div class="col-md-3 mb-2">
                                    <label for="cupom" class="form-label">Cupom</label>
                                    <input class="form-control" type="text" name="cupom" id="cupom">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection