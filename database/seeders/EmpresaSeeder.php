<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Holding;
use App\Models\HoldingUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        // Cadastrando 5 holdings
        for ($i = 1; $i <= 1; $i++) {
            $holding = Holding::create([
                'nome' => 'GoUp',
                'cnpj' => $faker->cnpj,
                'telefone' => $faker->phoneNumber,
                'site' => 'https://goupcontabilidade.com.br/',
                'email' => $faker->companyEmail,
                'nome_fantasia' => $faker->companySuffix,
                'data_abertura' => $faker->date,
                'inscricao_municipal' => $faker->randomNumber(8, true),
                'cep' => '24440560',
                'logradouro' => 'rua cirilo branco',
                'numero' => '396',
                'bairro' => 'porto da pedra',
                'cidade' => 'são gonçalo',
                'estado' => 'rio de janeiro',
                'cnae' => $faker->randomNumber(5, true),
                'capital_social' => $faker->randomFloat(2, 10000, 500000),
                'faturamento_anual' => $faker->randomFloat(2, 50000, 1000000),
                'responsavel_contabil' => $faker->name,
                'codigo_tributacao' => $faker->randomNumber(4, true),
                'aliquota_fiscais' => $faker->randomFloat(2, 0, 30),
                'natureza_juridica' => 'EI',
                'regime_tributario' => 'Simples Nacional',
            ]);

            // Cadastrando 10 usuários para cada holding
            for ($j = 1; $j <= 1; $j++) {
                HoldingUser::create([
                    'name' => 'GoUp Holding',
                    'email' => 'goupcontabilidade@comercial.com.br',
                    'password' => Hash::make('123456a', ['rounds' => 12]),
                    'holding_id' => $holding->id,
                    'nome_completo' => 'GoUp Holding',
                    'cpf' => $faker->cpf,
                    'data_nascimento' => $faker->date,
                    'telefone' => $faker->phoneNumber,
                    'cargo' => $faker->jobTitle,
                    'departamento' => $faker->word,
                ]);
            }

            // Cadastrando 5 empresas para cada holding
            for ($k = 1; $k <= 1; $k++) {
                $empresa = Empresa::create([
                    'razao_social' => 'GoUp',
                    'cnpj' => $faker->cnpj,
                    'telefone' => $faker->phoneNumber,
                    'site' => 'https://goupcontabilidade.com.br/',
                    'email' => $faker->companyEmail,
                    'nome_fantasia' => $faker->companySuffix,
                    'cep' => '24440560',
                    'logradouro' => 'rua cirilo branco',
                    'numero' => '396',
                    'bairro' => 'porto da pedra',
                    'cidade' => 'são gonçalo',
                    'estado' => 'rio de janeiro',
                    'holding_id' => $holding->id,
                ]);

                // Cadastrando 10 usuários para cada empresa
                for ($l = 1; $l <= 1; $l++) {
                    User::create([
                        'name' => 'Teste GoUp',
                        'email' => 'goup@teste.com.br',
                        'password' => Hash::make('123456a', ['rounds' => 12]),
                        'empresa_id' => $empresa->id,
                        'nome_completo' => 'GoUp teste',
                        'cpf' => '00000000000',
                        'data_nascimento' => $faker->date,
                        'telefone' => $faker->phoneNumber,
                        'cargo' => 'CEO',
                    ]);
                }
            }
        }
    }
}
