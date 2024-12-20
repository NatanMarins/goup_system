<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\SociosDocumento;
use App\Models\TomadorServico;
use Illuminate\Http\Request;

class SocioController extends Controller
{
    public function sociosShow($tomadorservico, $socio)
    {
        $socio = Socio::findOrFail($socio);

        return view('empresas.tomador.sociosShow', compact('tomadorservico', 'socio'));
    }

    public function sociosDocumentos($tomadorservico, $socio)
    {
        $socio = Socio::findOrFail($socio);

        $documentos = SociosDocumento::where('socio_id', $socio->id)->get();

        return view('empresas.tomador.sociosDocumentos', compact('socio', 'documentos'));
    }
}
