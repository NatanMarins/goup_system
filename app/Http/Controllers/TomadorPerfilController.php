<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\SociosDocumento;
use App\Models\TomadorServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TomadorPerfilController extends Controller
{
    public function showTomador()
    {
        $tomador = auth()->user();

        return view('tomadores.profile.show', compact('tomador'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'senhaAtual' => 'required',
            'novaSenha' => 'required|min:6',
            'confirmarSenha' => 'required',
        ]);

        $tomador = auth()->user();

        // Verifica se a senha atual está correta
        if (!Hash::check($request->senhaAtual, $tomador->password)) {
            return redirect()->back()->with('error', 'Senha atual incorreta!');
        }

        // Verifica se a nova senha é igual a senha de confirmação
        if ($request->novaSenha != $request->confirmarSenha) {
            return redirect()->back()->with('error', 'As senhas não coincidem!');
        }

        // Atualiza a senha do tomador
        $tomador->password = Hash::make($request->novaSenha);
        $tomador->save();


        return redirect()->back()->with('success', 'Senha alterada com sucesso!');
    }

    public function addDocumentos()
    {
        return view('tomadores.profile.addDocumentos');
    }

    public function storeDocumentos(Request $request)
    {
        // Validar os arquivos enviados
        $request->validate([
            'contrato_social.*' => 'file|mimes:pdf,jpeg,png',
            'alvara_funcionamento.*' => 'file|mimes:pdf,jpeg,png',
            'inscricao_estadual.*' => 'file|mimes:pdf,jpeg,png',
        ]);

        // Array para armazenar os dados a serem inseridos
        $documentos = [];

        // Iterar sobre os campos de arquivos
        foreach (['contrato_social', 'alvara_funcionamento', 'inscricao_estadual'] as $tipo) {
            if ($request->hasFile($tipo)) {
                foreach ($request->file($tipo) as $file) {
                    // Gerar um identificador único para o arquivo
                    $filename = uniqid() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('documentos', $filename);

                    // Adicionar os dados ao array
                    $documentos[] = [
                        'tipo' => ucfirst(str_replace('_', ' ', $tipo)), // Converte para "Contrato Social", etc.
                        'path' => $path,
                        'descricao' => $file->getClientOriginalName(),
                        'tomador_servico_id' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Inserir os dados no banco de dados
        \Illuminate\Support\Facades\DB::table('documentos')->insert($documentos);

        return redirect()->route('tomadores.profile.show')->with('success', 'Documentos adicionados com sucesso!');
    }

    public function editTomador()
    {
        $tomador = auth()->user();

        return view('tomadores.profile.edit', compact('tomador'));
    }

    public function updateTomador(Request $request)
    {
        $tomadorId = auth()->id();
        $tomadorServico = TomadorServico::find($tomadorId);

        $request->validate([
            'nome_fantasia' => 'required|string|max:255',
            'cnpj' => 'nullable|cnpj',
            'telefone' => 'required',
            'email' => 'required|email',
            'data_abertura' => 'nullable',
            'inscricao_municipal' => 'nullable',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'cnae' => 'nullable',
            'capital_social' => 'nullable',
            'faturamento_anual' => 'nullable',
            'responsavel_contabil' => 'nullable',
            'codigo_tributacao' => 'nullable',
            'aliquota_fiscais' => 'nullable',
            'natureza_juridica' => 'nullable',
            'regime_tributario' => 'nullable',
        ], [
            // Mensagens de erro
            'nome_fantasia.required' => 'O campo Nome é obrigatório.',
            'cnpj.cnpj' => 'Informe um CNPJ válido para o campo CNPJ.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Informe um E-mail válido para o campo E-mail.',
            'site.url' => 'Informe uma URL válida.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
        ]);

        $tomadorServico->update($request->all());

        return redirect()->route('tomadores.profile.show')->with('success', 'Dados atualizado com sucesso!');
    }

    public function addSocio()
    {
        return view('tomadores.profile.addSocios');
    }

    public function storeSocio(Request $request)
    {
        $validated = $request->validate([
            'socios.*.nome' => 'required|string|max:255',
            'socios.*.estado_civil' => 'required|string|max:255',
            'socios.*.profissao' => 'required|string|max:255',
            'socios.*.identidade' => 'required|string|max:255',
            'socios.*.cpf' => 'required|cpf',
            'socios.*.email' => 'required|email',
            'socios.*.telefone' => 'required|string',
            'socios.*.cep' => 'required|string',
            'socios.*.estado' => 'required|string',
            'socios.*.cidade' => 'required|string',
            'socios.*.bairro' => 'required|string',
            'socios.*.logradouro' => 'required|string',
            'socios.*.numero' => 'required|string',
            'socios.*.documentos.*.*' => 'file|mimes:jpg,jpeg,png,pdf',
        ]);
    
        foreach ($request->socios as $socioData) {
            $socio = Socio::create([
                'tomador_servico_id' => auth()->id(),
                'nome' => $socioData['nome'],
                'estado_civil' => $socioData['estado_civil'],
                'profissao' => $socioData['profissao'],
                'identidade' => $socioData['identidade'],
                'cpf' => $socioData['cpf'],
                'email' => $socioData['email'],
                'telefone' => $socioData['telefone'],
                'cep' => $socioData['cep'],
                'estado' => $socioData['estado'],
                'cidade' => $socioData['cidade'],
                'bairro' => $socioData['bairro'],
                'logradouro' => $socioData['logradouro'],
                'numero' => $socioData['numero'],
            ]);
    
            if (isset($socioData['documentos'])) {
                foreach ($socioData['documentos'] as $tipo => $arquivos) {
                    foreach ($arquivos as $arquivo) {
                        $filename = uniqid() . '_' . $arquivo->getClientOriginalName();
                        $caminho = $arquivo->storeAs('documentos', $filename);

                        SociosDocumento::create([
                            'socio_id' => $socio->id,
                            'tipo' => $tipo,
                            'descricao' => $arquivo->getClientOriginalName(),
                            'caminho' => $caminho,
                        ]);
                    }
                }
            }
        }
        return redirect()->route('tomadores.profile.show')->with('success', 'Sócios cadastrados com sucesso!');
    }
}
