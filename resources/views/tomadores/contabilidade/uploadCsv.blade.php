@extends('tomadores.layout.admin')

@section('content')

    <x-alert/>

    <h2>Enviar Arquivo CSV</h2>
    <form action="{{ route('tomadores.contabilidade.processarCsv') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit">Enviar</button>
    </form>
@endsection
