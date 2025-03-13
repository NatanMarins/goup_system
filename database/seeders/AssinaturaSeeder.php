<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssinaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assinaturas')->insert([
            [
                'planos' => 'Empreendedor',
                'valor_mensal' => 9.99,
                'valor_anual' => 99.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'planos' => 'Visionário',
                'valor_mensal' => 19.99,
                'valor_anual' => 199.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'planos' => 'Líder',
                'valor_mensal' => 29.99,
                'valor_anual' => 299.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'planos' => 'MEI',
                'valor_mensal' => 19.99,
                'valor_anual' => 150.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'planos' => 'E-Social',
                'valor_mensal' => 19.99,
                'valor_anual' => 150.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
