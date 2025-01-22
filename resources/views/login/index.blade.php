<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Up-System</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>

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
         /* apagar */
        .position-relative {
            position: relative; /* Define o pai como relativo */
        }
    
        .toggle-password {
            position: absolute; /* Para ser posicionado em relação ao pai */
            top: 50%; /* Centraliza verticalmente no input */
            right: 15px; /* Distância da borda direita do campo de input */
            transform: translateY(-50%); /* Ajuste fino para centralizar melhor verticalmente */
            cursor: pointer; /* Para indicar que o ícone é clicável */
            color: #6c757d; /* Cor do ícone */
        }
    
        .form-control {
            padding-right: 2.5rem; /* Cria espaço suficiente para o ícone à direita */
        }
        /* apagar */

 /* Reset básico */
 * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Container principal */
.login-container {
    display: flex;
    height: 100vh;
    
}

/* Lateral da imagem */
.image-section {
    flex: 1;
    background: #0d454c url('https://www.dinerb.com.br/goup/wp-content/uploads/2024/12/1.jpg') no-repeat center center/cover;
}

/* Lateral do formulário */
.form-section {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #0d454c;
    padding: 20px;
}

/* Card de login */
.login-card {
    background: #fff;
    padding: 40px 30px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    text-align: center;
}

.login-card h2 {
    margin-bottom: 20px;
    color: #0d454c;
}

/* Formulário */
.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #0d454c;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

/* Grupo de senha com ícone */
.password-group .password-wrapper {
    position: relative;
}

.password-group .toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #aaa;
    font-size: 16px;
}

/* Checkbox de permanecer logado */
.remember-me {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #0d454c;
}

.remember-me input {
    width: auto;
}

/* Botão de login */
.login-btn {
    width: 100%;
    padding: 10px;
    background-color: #249f82;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-btn:hover {
    background-color: #1a7b68;
}

/* Link Esqueceu a Senha */
.forgot-password {
    display: block;
    margin-top: 10px;
    font-size: 14px;
    color: #249f82;
    text-decoration: none;
    text-align: center;
}

.forgot-password:hover {
    text-decoration: underline;
}

/* Responsividade */
@media (max-width: 768px) {
    .login-container {
        flex-direction: column;
    }

    .image-section {
        height: 200px;
        flex: 0;
    }

    .form-section {
        flex: 1;
        padding: 10px;
    }
}


    </style>


<body>
    <div class="login-container">
        <!-- Lateral com a imagem -->
        <div class="image-section"></div>

        <!-- Lateral com o card de login -->
        <div class="form-section">
            <div class="login-card">
                <div class="brand-logo text-center">
                    <img src="https://www.dinerb.com.br/goup/wp-content/uploads/2023/09/goup-logo.png" alt="Logo da Empresa">
                </div>

                <x-alert />
                <form action="{{ route('login.process') }}" method="POST" class="pt-3">
                    @csrf
                    @method('POST')
                
                    <!-- Campo de Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}">
                    </div>
                    
                    <!-- Campo de Senha com ícone de visualização -->
                    <div class="form-group password-group">
                        <label for="password">Senha</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
                            <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
                        </div>
                    </div>
                    
                    <!-- Botão de Login e link Esqueceu a Senha -->
                    <div class="form-actions">
                        <button type="submit" class="login-btn">Entrar</button>
                        <a href="#" class="forgot-password">Esqueceu sua senha?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


<script>
    // Alternar visibilidade da senha
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const passwordToggle = document.querySelector('.toggle-password');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggle.textContent = '🙈'; // Ícone para senha visível
    } else {
        passwordInput.type = 'password';
        passwordToggle.textContent = '👁️'; // Ícone para senha oculta
    }
}
</script>
