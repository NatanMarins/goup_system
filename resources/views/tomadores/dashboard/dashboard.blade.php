@extends('tomadores.layout.admin')

@section('content')

<x-alert />

<style>
    .icon {
        font-size: 40px;
        color: #01c592;
    }

    
.glow {
    box-shadow: 0 0 5px rgba(0, 70, 77, 0.3);
    transition: box-shadow 0.3s ease;
}

.glow:hover {
    box-shadow: 0 0 10px rgba(0, 70, 77, 0.5);
}

</style>

<x-alert />

<div class="row">
    <!-- Conteúdo Principal -->
    <main class="col-md-9 ms-sm-auto col-lg-12 px-md-4">
        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center">
            <div>Bem-vindo, {{ auth()->user()->name }}!</div>
         </div>

        <!-- Cards com Métricas -->
        <div class="row mt-4">
            <!-- Card 1 -->
            <div class="col-md-4 mb-3">
                <div class="card p-3 glow">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-chart-line icon me-3"></i>
                        <div>
                            <h5 class="card-title text-success">Receita Bruta</h5>
                            <p class="card-text fs-4">R$ 12.500,00</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4 mb-3">
                <div class="card p-3 glow">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-money-bill-trend-up icon me-3"></i>
                        <div>
                            <h5 class="card-title text-danger">Despesas Totais</h5>
                            <p class="card-text fs-4">R$ 7.200,00</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4 mb-3">
                <div class="card p-3 glow">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-wallet icon me-3"></i>
                        <div>
                            <h5 class="card-title text-primary">Saldo em Caixa</h5>
                            <p class="card-text fs-4">R$ 5.300,00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-4 mt-3">
                <div class="card p-3 glow">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-users icon me-3"></i>
                        <div>
                            <h5 class="card-title text-info">Novos Clientes</h5>
                            <p class="card-text fs-4">15</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 5 -->
            <div class="col-md-4 mt-3">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-file-invoice icon me-3"></i>
                        <div>
                            <h5 class="card-title text-warning">Faturas Pendentes</h5>
                            <p class="card-text fs-4">8</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 6 -->
            <div class="col-md-4 mt-3">
                <div class="card p-3 glow">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-clipboard-check icon me-3"></i>
                        <div>
                            <h5 class="card-title text-secondary">Relatórios Enviados</h5>
                            <p class="card-text fs-4">22</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráfico Placeholder -->
        <div class="row mt-4">
            <div class="col">
                <div class="card p-3 glow">
                    <h5 class="card-title">Gráfico</h5>
                    <div style="height: 300px; background-color: #F0F1F5; text-align: center; line-height: 300px;">
                        [Gráfico Aqui]
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection

