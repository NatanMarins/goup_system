@extends('empresas.admin.layout.admin')

@section('content')
    <style>
        .icon {
            font-size: 40px;
            color: #01c592;
        }

        .card {
            border-radius: 8px;
            color: white;
            padding: 10px;
            position: relative;

            .zmdi {
                color: white;
                font-size: 28px;
                opacity: 0.3;
                position: absolute;
                right: 13px;
                top: 13px;
            }

            .stat {
                border-top: 1px solid rgba(255, 255, 255, 0.3);
                font-size: 12px;
                margin-top: 25px;
                padding: 10px 10px 0;
                text-transform: uppercase;
            }

            .title {
                display: inline-block;
                font-size: 12px;
                padding: 10px 10px 0;
                text-transform: uppercase;
            }

            .value {
                font-size: 28px;
                padding: 0 10px;
            }

            &.blue {
                background-color: #2298F1;
            }

            &.green {
                background-color: #66B92E;
            }

            &.orange {
                background-color: #DA932C;
            }

            &.red {
                background-color: #D65B4A;
            }
        }
    </style>

    <x-alert />

    <div class="row">
        <!-- Conteúdo Principal -->
        <main class="col-md-9 ms-sm-auto col-lg-12 px-md-4">
            <!-- cards -->
            <div class="card-list pt-4">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 col-xl-2 mb-4">
                        <div class="card blue">
                            <div class="title">Total de Assinaturas</div>
                            <div class="value">{{ $totalAssinaturas }}</div>
                            <div class="stat"><b>100</b>%</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-2 mb-4">
                        <div class="card green">
                            <div class="title">Assinaturas Adimplentes</div>
                            <div class="value">{{ $adimplentes }}</div>
                            <div class="stat"><b>{{ $percentual['adimplentes'] }}</b>%</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-2 mb-4">
                        <div class="card orange">
                            <div class="title">Assinaturas Pendentes</div>
                            <div class="value">{{ $pendentes }}</div>
                            <div class="stat"><b>{{ $percentual['pendentes'] }}</b>%</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-2 mb-4">
                        <div class="card red">
                            <div class="title">Assinaturas Inadimplentes</div>
                            <div class="value">{{ $inadimplentes }}</div>
                            <div class="stat"><b>{{ $percentual['inadimplentes'] }}</b>%</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-2 mb-4">
                        <div class="card red">
                            <div class="title">Abando de Carrinho</div>
                            <div class="value">{{ $abandonos }}</div>
                            <div class="stat"><b>{{ $percentual['abandonos'] }}</b>%</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- cards -->

            <!-- Cards com Métricas -->
            <div class="row mt-3">
                <!-- Card 1 -->
                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="card-title text-success">Gráfico</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="card-title text-success">Gráfico</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="card-title text-success">Gráfico</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-4 mt-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="card-title text-success">Gráfico</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 5 -->
                <div class="col-md-4 mt-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="card-title text-success">Gráfico</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 6 -->
                <div class="col-md-4 mt-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="card-title text-success">Gráfico</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Gráfico Placeholder -->
            <div class="row mt-4">
                <div class="col">
                    <div class="card p-3">
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
