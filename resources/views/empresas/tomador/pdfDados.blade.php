<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tomador->nome }}</title>

    <link href="{{ asset('css/style.css.map') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor.bundle.base.css') }}" rel="stylesheet">

    <link href="{{ asset('css/typicons.css') }}" rel="stylesheet">

    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    <script src='https://use.fontawesome.com/releases/v6.3.0/js/all.js' crossorigin='anonymous'></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- inject:css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- endinject -->
    <link href="{{ asset('assets/images/favicon.ico') }}" rel="stylesheet">

</head>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .logo {
        width: 150px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
        margin: 0 auto;
    }

    th,
    td {
        padding: 12px 12px;
        border-bottom: 1px solid #ddd;
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }

    th {
        color: #000;
        ;
    }

    @media (max-width: 768px) {
        table {
            font-size: 12px;
        }

        th,
        td {
            padding: 5px;
        }
    }
</style>

<body>

    <table>
        <tr>
            <th rowspan="2"><img src="{{ public_path('images/logo.png') }}" alt="Logo" class="logo"></th>
            <th colspan="5"><strong>Cliente </strong><br /> {{ $tomador->nome }}</th>
        <tr>
            <th><strong>Status: </strong><br /> {{ $tomador->status }}</th>
            <th><strong>Código do Cliente:</strong> <br /> {{ $tomador->codigo_cliente }}</th>
            <th colspan="2"><strong>CNPJ:</strong><br /> {{ $tomador->cnpj }}</th>
            <th><strong>Data de Abertura:</strong> <br />{{ $tomador->data_abertura }}</th>
        </tr>
        </tr>

        <tr>
            <th colspan="6" style="background-color:  #00464D; color:#ffffff;"> Detalhes da Empresa</th>
        </tr>

        <tr>
            <td><strong>Natureza Juridica:</strong><br /> {{ $tomador->natureza_juridica }}</td>
            <td colspan="2"><strong>Regime Tributario:</strong><br />{{ $tomador->regime_tributario }}</td>
            <td><strong>Código Tributação:</strong><br />{{ $tomador->codigo_tributacao }}</td>
            <td colspan="2"><strong>Capital Social:</strong><br />{{ $tomador->capital_social }}</td>
        </tr>

        <tr>
            <td colspan="6"><strong>CNAE:</strong><br />{{ $tomador->cnae }}</td>
        </tr>

        <tr>
            <td colspan="3"><strong>Nome Fantasia:</strong><br /> {{ $tomador->nome_fantasia }}</td>
            <td colspan="3"><strong>Razao Social:</strong><br /> {{ $tomador->razao_social }}</td>
        </tr>

        <tr>
            <td colspan="3"><strong>Inscrição Estadual:</strong><br /> {{ $tomador->inscricao_estadual }}</td>
            <td colspan="3"><strong>Inscrição Municipal:</strong><br />{{ $tomador->inscricao_municipal }}</td>
        </tr>

        <tr>
            <th colspan="6" style="background-color: #00464D; color:#ffffff;">Contato</th>
        </tr>

        <tr>
            <td colspan="2"><strong>Telefone:</strong><br /> {{ $tomador->telefone }}</td>
            <td colspan="2"> <strong>E-mail:</strong><br /> {{ $tomador->email }}</td>
            <td colspan="2"> <strong>Site:</strong><br /> {{ $tomador->site }} </td>
        </tr>

        <tr>
            <td colspan="3"><strong>Logradouro:</strong><br /> {{ $tomador->logradouro }}</td>
            <td> <strong>Número:</strong><br /> {{ $tomador->numero }}</td>
            <td colspan="2"> <strong>Complemento:</strong><br /> {{ $tomador->complemento }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong>Bairro:</strong><br /> {{ $tomador->bairro }}</td>
            <td colspan="2"><strong>Cidade:</strong><br /> {{ $tomador->cidade }}</td>
            <td><strong>Estado:</strong><br /> {{ $tomador->estado }} </td>
            <td><strong>CEP:</strong><br /> {{ $tomador->cep }}</td>
        </tr>

        @forelse ($socios as $socio)
            <tr>
                <th colspan="6" style="background-color: #00464D; color:#ffffff;">Sócio(s)</th>
            </tr>

            <tr>
                <td colspan="4"><strong>Nome:</strong><br />{{ $socio->nome }}</td>
                <td colspan="2"><strong>Estado Civil:</strong><br />{{ $socio->estado_civil }}</td>
            </tr>

            <tr>
                <td colspan="4"><strong>Profissão:</strong><br />{{ $socio->profissao }}</td>
                <td><strong>Identidade:</strong><br />{{ $socio->identidade }}</td>
                <td><strong>CPF:</strong><br />{{ $socio->cpf }}</td>
            </tr>

        @empty
            <tr>
                <td>Nenhum Sócio Cadastrado</td>
            </tr>
        @endforelse

    </table>
</body>

</html>
