<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Up-System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
</head>

<style>
    .titulo {
        color: #eef0f4;
        font-weight: 300;
        font-size: 50px;
        letter-spacing: .2rem;
        text-transform: uppercase;
        position: relative;
        display: inline-block;
    }

    .titulo::after {
        content: '';
        /* Adiciona elemento vazio para a linha */
        display: block;
        /* Define como um bloco */
        width: 150px;
        /* Linha acompanha a largura do texto */
        height: 5px;
        /* Altura da linha */
        background-color: #249f82;
        /* Cor da linha */
        margin-top: 5px;
        /* Espaço entre o título e a linha */
    }

    .themeBtn {
        background: #249f82;
        color: #ffffff !important;
        display: inline-block;
        font-size: 15px;
        font-weight: 500;
        height: 50px;
        line-height: 0.8;
        padding: 18px 30px;
        text-transform: capitalize;
        border-radius: 1px;
        letter-spacing: 0.5px;
        border: 0px !important;
        cursor: pointer;
        border-radius: 100px;

    }

    a:hover {
        color: #ffffff;
        text-decoration: none;
    }

    .themeBtn:hover {
        background: #0d454c;
        color: #ffffff;
        box-shadow: 0 10px 25px -2px rgba(13, 69, 76, 0.6);
    }

    .borda {
        border-bottom: 1px solid #249f82;
        padding: 0px 0px 5px 0px;
    }

    .section_our_solution .row {
        align-items: center;
    }

    .our_solution_category {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .our_solution_category .solution_cards_box {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .solution_cards_box .solution_card {
        flex: 0 50%;
        background: #eef0f4;
        box-shadow: 0 2px 4px 0 rgba(136, 144, 195, 0.2),
            0 5px 15px 0 rgba(37, 44, 97, 0.15);
        border-radius: 15px;
        margin: 8px;
        padding: 10px 15px;
        position: relative;
        z-index: 1;
        overflow: hidden;
        min-height: 265px;
        transition: 0.7s;
    }

    .solution_cards_box .solution_card:hover {
        background: #249f82;
        color: #fff;
        transform: scale(1.1);
        z-index: 9;
    }

    .solution_cards_box .solution_card:hover::before {
        background: #249f82;
    }

    .solution_cards_box .solution_card:hover .solu_title h3,
    .solution_cards_box .solution_card:hover .solu_description p {
        color: #fff;
    }


    .solution_cards_box .solution_card:hover .solu_description a {
        background: #fff !important;
        color: #0d454c;
    }

    .solution_card .so_top_icon {}

    .solution_card .solu_title h3 {
        color: #212121;
        font-size: 30px;
        margin-top: 20px;
        margin-bottom: 13px;
    }

    .solution_card .solu_description p {
        font-size: 15px;
        margin-bottom: 15px;
    }

    .solution_card .solu_description a {
        border: 0;
        border-radius: 15px;
        background: #0d454c;
        color: #fff;
        font-weight: 500;
        font-size: 1rem;
        padding: 5px 16px;
        text-decoration: none;
    }

    .our_solution_content h1 {
        text-transform: capitalize;
        margin-bottom: 1rem;
        font-size: 2.5rem;
    }

    .our_solution_content p {}

    .solution_cards_box .solution_card .so_top_icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #fff;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .solution_cards_box .solution_card .so_top_icon img {
        width: 40px;
        height: 50px;
        object-fit: contain;
    }

    /start media query/ @media screen and (min-width: 320px) {
        .sol_card_top_3 {
            position: relative;
            top: 0;
        }

        .our_solution_category {
            width: 100%;
            margin: 0 auto;
        }

        .our_solution_category .solution_cards_box {
            flex: auto;
        }
    }

    @media only screen and (min-width: 768px) {
        .our_solution_category .solution_cards_box {
            flex: 1;
        }
    }

    @media only screen and (min-width: 1024px) {
        .sol_card_top_3 {
            position: relative;
            top: -3rem;
        }

        .our_solution_category {
            width: 50%;
            margin: 0 auto;
        }
    }
</style>

<body style="background: #0d454c;">

    <!-- main-panel ends -->
    <div class="main-panel">
        <div class="content-wrapper">

            @yield('content')

        </div>

        <script>
            $(document).ready(function() {
                // Máscara para CNPJ
                $('#cnpj').mask('00.000.000/0000-00');

                // Máscara para o Telefone (com DDD)
                $('#telefone').mask('(00) 00000-0000');

                // Máscara para CPF
                $('#cpf').mask('000.000.000-00');

                // Máscara para CEP
                $('#cep').mask('00000-000');

                // Mascara para RG
                $('.identidade').mask('000.000.000-0');

            });
        </script>

        <script>
            document.getElementById('cep').addEventListener('blur', function() {
                let cep = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos

                if (cep.length !== 8) { // Verifica se o CEP tem 8 dígitos (uso !== para ser mais estrito)
                    alert('CEP inválido. Digite um CEP com 8 números.');
                    limparCamposEndereco(); // Limpa os campos
                    return; // Importante: sai da função para evitar a requisição
                }

                fetch(`https://viacep.com.br/ws/${cep}/json/`) // URL corrigida (sem espaço extra)
                    .then(response => {
                        if (!response.ok) { // Verifica se a resposta foi bem-sucedida (status 2xx)
                            throw new Error(
                            `Erro na requisição: Status ${response.status}`); // Lança um erro com o status
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.erro) { // Verifica se o CEP não foi encontrado
                            alert('CEP não encontrado.');
                            limparCamposEndereco(); // Limpa os campos
                        } else {
                            // Preenche os campos de endereço com os dados retornados
                            document.getElementById('logradouro').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                            // Preenche o campo complemento, caso exista na resposta
                            document.getElementById('complemento').value = data.complemento || '';
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar o CEP:', error);
                        alert(
                        'Erro ao buscar o CEP. Verifique sua conexão e tente novamente.'); // Mensagem mais informativa
                        limparCamposEndereco(); // Limpa os campos em caso de erro na requisição
                    });
            });

            function limparCamposEndereco() {
                document.getElementById('logradouro').value = '';
                document.getElementById('bairro').value = '';
                document.getElementById('cidade').value = '';
                document.getElementById('estado').value = '';
                document.getElementById('complemento').value = '';
            }
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


</body>

</html>
