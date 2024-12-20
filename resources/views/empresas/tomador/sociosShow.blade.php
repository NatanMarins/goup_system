@extends('empresas.layout.admin')

@section('content')

    <div class="container">
        <p>Nome: {{ $socio->nome }}</p>
        <p>Identidade: {{ $socio->identidade }}</p>
        <p>CPF: {{ $socio->cpf }}</p>
        <p>Profissão: {{ $socio->profissao }}</p>
        <p>Estado Civil: {{ $socio->estado_civil }}</p>
        <p>Email: {{ $socio->email }}</p>
        <p>Telefone: {{ $socio->telefone }}</p>
        <p>CEP: {{ $socio->cep }}</p>
        <p>Estado: {{ $socio->estado }}</p>
        <p>Cidade: {{ $socio->cidade }}</p>
        <p>Bairro: {{ $socio->bairro }}</p>
        <p>Logradouro: {{ $socio->logradouro }}</p>
        <p>Número: {{ $socio->numero }}</p>
        <p>Complemento: {{ $socio->complemento ?? 'N/A' }}</p>

        <a href="{{ route('empresas.tomador.sociosDocumentos', ['tomadorservico' => $tomadorservico, 'socio' => $socio->id]) }}">Documentos</a>

    </div>
@endsection
