@extends('tomadores.planos.layout.admin')

@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <div class="container mt-5">
        <h1 class="mb-5 pt-2 titulo">Escolha o Serviço</h1>
        <div class="row">
            <!-- Link para Abertura de Empresa -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="solution_cards_box">
                    <div class="solution_card text-center">
                        <div class="hover_color_bubble"></div>
                        <div class="so_top_icon">
                            <img src="https://www.dinerb.com.br/goup/wp-content/uploads/2024/11/simbolo-site.png">
                        </div>
                        <div class="solu_title">
                            <h3>Abertura de Empresa</h3>
                        </div>
                        <div class="solu_description">
                            <p>Precisa abrir sua empresa?<br /> Clique no link abaixo e saiba mais.</p>
                            <a href="{{ route('tomadores.planos.aberturaEmpresa') }}" class="read_more_btn">Abertura de
                                Empresa</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Link para Abertura de Empresa -->

            <!-- Link para Troca de Contador -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="solution_cards_box">
                    <div class="solution_card text-center">
                        <div class="hover_color_bubble"></div>
                        <div class="so_top_icon">
                            <img src="https://www.dinerb.com.br/goup/wp-content/uploads/2024/11/simbolo-site.png">
                        </div>
                        <div class="solu_title">
                            <h3>Troca de Contador</h3>
                        </div>
                        <div class="solu_description">
                            <p>Deseja trocar de contador?<br /> Clique no link abaixo e veja como.</p>
                            <a href="{{ route('tomadores.planos.trocaContador') }}" class="read_more_btn">Troca de
                                Contador</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Link para Troca de Contador -->

            <!-- Link para Regularizar o MEI -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="solution_cards_box">
                    <div class="solution_card text-center">
                        <div class="hover_color_bubble"></div>
                        <div class="so_top_icon">
                            <img src="https://www.dinerb.com.br/goup/wp-content/uploads/2024/11/simbolo-site.png">
                        </div>
                        <div class="solu_title">
                            <h3>Regularizar o MEI</h3>
                        </div>
                        <div class="solu_description">
                            <p>Precisa abrir sua empresa?<br /> Clique no link abaixo e saiba mais.</p>
                            <a href="{{ route('tomadores.planos.regularizaMei') }}" class="read_more_btn">Regularizar
                                MEI</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Link para Regularizar o MEI -->

            <!-- Link para Regularizar eSocial -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="solution_cards_box">
                    <div class="solution_card text-center">
                        <div class="hover_color_bubble"></div>
                        <div class="so_top_icon">
                            <img src="https://www.dinerb.com.br/goup/wp-content/uploads/2024/11/simbolo-site.png">
                        </div>
                        <div class="solu_title">
                            <h3>Regularizar eSocial</h3>
                        </div>
                        <div class="solu_description">
                            <p>Precisa abrir sua empresa?<br /> Clique no link abaixo e saiba mais.</p>
                            <a href="{{ route('tomadores.planos.regularizaEsocial') }}" class="read_more_btn">Regularizar
                                eSocial</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Link para Regularizar eSocial -->
        </div>
    </div>
@endsection
