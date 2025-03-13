<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GoUp-System</title>
    <!-- base:css -->

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
        background: #1e1e1f;
    }

    .user-row {
        padding: 10px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
    }

    .user-details strong {
        color: #00464D;
    }

    .user-last-login {
        color: #6c757d;
    }
</style>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center" style="background:#1e1f1f;">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <a class="navbar-brand brand-logo" href="{{ route('empresas.dashboard.dashboard') }}"><img
                            src="{{ asset('https://www.dinerb.com.br/goup/wp-content/uploads/2024/12/2-1.png') }}"
                            alt="Logo da Empresa"></a>
                    <a class="navbar-brand brand-logo-mini" href="{{ route('empresas.dashboard.dashboard') }}"><img
                            src="{{ asset('https://www.dinerb.com.br/goup/wp-content/uploads/2024/12/3-1.png') }}"
                            alt="Logo da Empresa"></a>
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <i class="fa-solid fa-bars mx-0"></i>
                    </button>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="background: #4b4b4d;">
                <ul class="navbar-nav me-lg-2">
                    <li class="nav-item nav-profile dropdown pt-2">
                        <!-- Usuário  -->
                        <div class="user-row">
                            <div class="user-info">
                                @if (Auth::check())
                                    <img src="{{ Auth::user()->foto_perfil ? asset('storage/' . Auth::user()->foto_perfil) : asset('imagens/default-avatar.png') }}"
                                        alt="Avatar" class="user-avatar">
                                @endif
                                <div class="user-details  pt-2">
                                    <strong style="color: #ffffff">{{ auth()->user()->name }}</strong>
                                    <div class="user-last-login">
                                        @if (Auth::user()->last_login_at)
                                            <p style="color: #ffffff">Último login: {{ Auth::user()->last_login_at->diffForHumans() }}</p>
                                        @else
                                            <p class="texto">Você ainda não fez login anteriormente.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Usuário  -->
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <!-- data-->
                    <li class="nav-item nav-date dropdown">
                        <a class="nav-link d-flex justify-content-center align-items-center" href="#">
                            <h6 class="date mb-0" style="color: #ffffff">{{ now()->format('d/m/Y') }}</h6>
                            <i class="typcn "></i> <i class="fa-regular fa-calendar-days" style="color: #ffffff;"></i>
                        </a>
                    </li>
                    <!-- data-->

                    <!-- Sair-->
                    <li class="nav-item dropdown me-0">
                        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
                            title="Sair do Sistema" id="notificationDropdown" href="{{ route('empresas.admin.logout') }}">
                            <i class="fa-regular fas fa-sign-out-alt mx-0" style="color: #ffffff;"></i>
                        </a>
                    </li>
                    <!-- Sair -->
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <i class="fa-solid fa-bars mx-0"></i>
                </button>
            </div>
        </nav>

        <div class="container-fluid page-body-wrapper" >

            <!-- partial:../../partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar" >
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('empresas.dashboard.dashboard') }}">

                            <i class="fa-solid fa-chart-line espaco menu-icon" style="color:#00464D;"></i>
                            <span class="menu-title">Dashboard</span>
                            <!-- <div class="badge badge-danger">new</div> -->
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('empresas.tomador.index') }}">
                            <i class="fa-regular fa-user espaco menu-icon" style="color:#00464D;"></i>
                            <span class="menu-title">Client Flow</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('empresas.usuario.index') }}">
                            <i class="fa-regular fas fa-users espaco menu-icon" style="color:#00464D;"></i>
                            <span class="menu-title">Usuários</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                            aria-controls="ui-basic">
                            <i class="fa-regular fas fa-users espaco menu-icon" style="color:#00464D;"></i>
                            <span class="menu-title">Assinatura</span>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ route('empresas.assinatura.configuracao') }}">Editar Valores</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ route('empresas.assinatura.cupom') }}">Cupom</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- partial -->

            <!-- main-panel ends -->
            <div class="main-panel">
                <div class="content-wrapper">

                    @yield('content')

                </div>

                <!-- footer -->
                <footer class="footer">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                                <span
                                    class="text-muted text-center text-sm-left d-block d-sm-inline-block">Desenvolvido
                                    por <a href="https://dinerb.com.br/" class="text-muted"
                                        target="_blank">DINERB</a>. Copyright ©
                                    {{ date('Y') }}
                                    <a href="https://dinerb.com.br/goup" class="text-muted" target="_blank">GoUp</a>.
                                    Todos os direitos reservados.</span>
                                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center text-muted">
                                    <a href="https://www.dinerb.com.br/goup/politica-de-privacidade/"
                                        class="text-muted" target="_blank">Política de
                                        Privacidade</a> | <a href="https://www.dinerb.com.br/goup/termo-de-uso/"
                                        class="text-muted" target="_blank">Termo
                                        de Uso</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- footer -->

            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- base:js -->
    <script src="{{ asset('js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->

    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <!-- endinject -->

    <!-- Plugin js for this page-->
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/chartist.js') }}"></script>
    <script src="{{ asset('js/jquery.cookie.js') }}"></script>

    <script src="{{ asset('js/all.min.js') }}"></script>

    <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
    <!-- End plugin js for this page-->

    <!-- Custom js for this page-->
    <script src="{{ asset('js/file-upload.js') }}"></script>
    <script src="{{ asset('js/typeahead.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <!-- End custom js for this page-->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts') <!-- Incluir scripts específicos da página -->

    <!-- jQuery (se ainda não estiver incluído) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Aplicar a máscara globalmente -->
    <script>
        $(document).ready(function() {
            // Máscara para CNPJ
            $('#cnpj').mask('00.000.000/0000-00');

            // Máscara para o Telefone (com DDD)
            $('#telefone').mask('(00) 00000-0000');

            // Máscara para CPF
            $('#cpf').mask('000.000.000-00');
        });
    </script>

    <script>
        document.getElementById('cep').addEventListener('blur', function() {
            let cep = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos

            if (cep.length === 8) { // Verifica se o CEP tem 8 dígitos
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            // Preenche os campos de endereço com os dados retornados
                            document.getElementById('logradouro').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        } else {
                            alert('CEP não encontrado.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar o CEP:', error);
                        alert('Erro ao buscar o CEP. Tente novamente.');
                    });
            } else {
                alert('CEP inválido. Digite um CEP com 8 números.');
            }
        });
    </script>
</body>

</html>
