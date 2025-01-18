@extends('tomadores.layout.admin')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        /* Custom styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
        }

        .drag-drop-area {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
        }

        .drag-drop-area.dragging {
            border-color: #007bff;
        }
    </style>

    <div class="container mt-5">

        <x-alert />

        <h1>Dados do Tomador</h1>

        <div class="mb-3">
            <button class="btn btn-primary" id="alterarSenhaBtn">Alterar Senha</button>
            <a href="#">
                <button class="btn btn-secondary">Adicionar Sócios</button>
            </a>
            <a href="{{ route('tomadores.profile.addDocumentos') }}">
                <button class="btn btn-info">Adicionar Documentos</button>
            </a>
            <a href="#">
                <button class="btn btn-success">Atualizar Dados</button>
            </a>
        </div>

        <div class="card p-3 mb-4">
            <h5>Informações do Tomador</h5>

            <form>
                <label>Nome Fantasia</label>
                <input type="text" class="form-control" value="{{ $tomador->nome_fantasia }}" disabled readonly>

                <label for="">Razao Social</label>
                <input type="text" class="form-control" value="{{ $tomador->razao_social }}" disabled readonly>

                <label for="">CNPJ</label>
                <input type="text" class="form-control" value="{{ $tomador->cnpj }}" disabled readonly>

                <label for="">Inscrição Estadual</label>
                <input type="text" class="form-control" value="{{ $tomador->inscricao_estadual }}" disabled readonly>

                <label for="">Inscrição Municipal</label>
                <input type="text" class="form-control" value="{{ $tomador->inscricao_municipal }}" disabled readonly>

                <label for="">Natureza Juridica</label>
                <input type="text" class="form-control" value="{{ $tomador->natureza_juridica }}" disabled readonly>

                <label for="">Regime Tributario</label>
                <input type="text" class="form-control" value="{{ $tomador->regime_tributario }}" disabled readonly>

                <label for="">Capital Social</label>
                <input type="text" class="form-control" value="{{ $tomador->capital_social }}" disabled readonly>

                <label for="">CNAE</label>
                <input type="text" class="form-control" value="{{ $tomador->cnae }}" disabled readonly>

                <label for="">Data Abertura</label>
                <input type="text" class="form-control" value="{{ $tomador->data_abertura }}" disabled readonly>

                <label for="">Código Tributação</label>
                <input type="text" class="form-control" value="{{ $tomador->codigo_tributacao }}" disabled readonly>

                <label for="">Email</label>
                <input type="text" class="form-control" value="{{ $tomador->email }}" disabled readonly>

                <label for="">Telefone</label>
                <input type="text" class="form-control" value="{{ $tomador->telefone }}" disabled readonly>

                <label for="">CEP</label>
                <input type="text" class="form-control" value="{{ $tomador->cep }}" disabled readonly>

                <label for="">Estado</label>
                <input type="text" class="form-control" value="{{ $tomador->estado }}" disabled readonly>

                <label for="">Cidade</label>
                <input type="text" class="form-control" value="{{ $tomador->cidade }}" disabled readonly>

                <label for="">Bairro</label>
                <input type="text" class="form-control" value="{{ $tomador->bairro }}" disabled readonly>

                <label for="">Logradouro</label>
                <input type="text" class="form-control" value="{{ $tomador->logradouro }}" disabled readonly>

                <label for="">Número</label>
                <input type="text" class="form-control" value="{{ $tomador->numero }}" disabled readonly>

                <label for="">Complemento</label>
                <input type="text" class="form-control" value="{{ $tomador->complemento }}" disabled readonly>
            </form>
        </div>


    </div>

    <!-- Popup para Alterar Senha -->
    <div class="popup-overlay" id="alterarSenhaPopup">
        <div class="popup-content">
            <h5>Alterar Senha</h5>

            <x-alert />

            <form action="{{ route('tomadores.profile.update-password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="senhaAtual" class="form-label">Senha Atual</label>
                    <input type="password" class="form-control" id="senhaAtual" name="senhaAtual" required>
                </div>
                <div class="mb-3">
                    <label for="novaSenha" class="form-label">Nova Senha</label>
                    <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
                </div>
                <div class="mb-3">
                    <label for="confirmarSenha" class="form-label">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" required>
                </div>
                <button type="submit" class="btn btn-primary">Alterar Senha</button>
                <button type="button" class="btn btn-secondary" id="fecharAlterarSenha">Cancelar</button>
            </form>

            <a href="#"><small>Esqueci a Senha</small></a>

        </div>
    </div>

    <script>
        // Abrir o popup ao clicar no botão
        document.getElementById('alterarSenhaBtn').addEventListener('click', () => {
            document.getElementById('alterarSenhaPopup').style.display = 'flex';
        });

        // Fechar o popup
        document.getElementById('fecharAlterarSenha').addEventListener('click', () => {
            document.getElementById('alterarSenhaPopup').style.display = 'none';
        });

        // Impedir o fechamento do popup durante o envio do formulário
        document.querySelector('#alterarSenhaPopup form').addEventListener('submit', () => {
            // O Laravel tratará o envio normal do formulário
            // Não fechar o popup automaticamente
            document.getElementById('alterarSenhaPopup').style.display = 'flex';
        });
    </script>
@endsection
