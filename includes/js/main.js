/********************************************************************************************************************************************/
/*                                                                      HEADER                                                              */
/********************************************************************************************************************************************/

$(document).ready(function () {

    //Impedir que qualquer click no formulario dê trigger ao backdrop
    $('.form').on('click', function (e) {
        e.stopPropagation();
    });

    //Esconder o container do login quando se clica no background/backdrop
    $('#login_backdrop').on('click', function () {
        $('#login_backdrop').removeClass('show').addClass('hide');
        $('#login').removeClass('hide').addClass('show');
    });

    $('#close_login').on('click', function () {
        $('#login_backdrop').removeClass('show').addClass('hide');
        $('#login').removeClass('hide').addClass('show');
    });

    //Esconder o container do signup quando se clica no background/backdrop
    $('#signup_backdrop').on('click', function () {
        $('#signup_backdrop').removeClass('show').addClass('hide');
        $('#login').removeClass('hide').addClass('show');
    });

    $('#close_signup').on('click', function () {
        $('#signup_backdrop').removeClass('show').addClass('hide');
        $('#login').removeClass('hide').addClass('show');
    });

    //Abrir o container do login
    $('#login').on('click', function () {
        $('#login_backdrop').removeClass('hide').addClass('show');
        $('#login').removeClass('show').addClass('hide');
        $('#signup_backdrop').removeClass('show').addClass('hide');
        $('#msg_backdrop').removeClass('show').addClass('hide');
    });

    $('#try_login').on('click', function () {
        $('#login_backdrop').removeClass('hide').addClass('show');
        $('#login').removeClass('show').addClass('hide');
        $('#signup_backdrop').removeClass('show').addClass('hide');
        $('#msg_backdrop').removeClass('show').addClass('hide');
    });

    //Abrir o container de registo do utilizador
    $('#registar').on('click', function () {
        $('#signup_backdrop').removeClass('hide').addClass('show');
        $('#login_backdrop').removeClass('show').addClass('hide');
        $('#login').removeClass('show').addClass('hide');
        $('#msg_backdrop').removeClass('show').addClass('hide');
    });

    $('#try_signup').on('click', function () {
        $('#signup_backdrop').removeClass('hide').addClass('show');
        $('#login_backdrop').removeClass('show').addClass('hide');
        $('#login').removeClass('show').addClass('hide');
        $('#msg_backdrop').removeClass('show').addClass('hide');
    });

    //Fechar Containers ao carregar na tecla ESC
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $('#login_backdrop').removeClass('show').addClass('hide');
            $('#signup_backdrop').removeClass('show').addClass('hide');
            $('#login').removeClass('hide').addClass('show');
        }
    })


    //Retroceder do signup para o login
    $('#back').on('click', function () {
        $('#login_backdrop').removeClass('hide').addClass('show');
        $('#login').removeClass('show').addClass('hide');
        $('#signup_backdrop').removeClass('show').addClass('hide');
        $('#msg_backdrop').removeClass('show').addClass('hide');
    });



    //Funções para visualizar password e trocar o símbolo
    $('.eye').on('mousedown', function () {
        $(this).attr('src', 'imgs/icons/eye.png');
        $('input[name="password"]').attr('type', 'text');
    });

    $('.eye').on('mouseup mouseleave', function () {
        $(this).attr('src', 'imgs/icons/closed-eye.png');
        $('input[name="password"]').attr('type', 'password');
    });

    $('.re_eye').on("mousedown", function () {
        $(this).attr('src', 'imgs/icons/eye.png');
        $('input[name="re_password"]').attr('type', 'text');
    });

    $('.re_eye').on("mouseup mouseleave", function () {
        $(this).attr('src', 'imgs/icons/closed-eye.png');
        $('input[name="re_password"]').attr('type', 'password');
    });

    //Função para garantir que não faltam dados na submissão do formulário de login
    $('#form_login').on('submit', function () {
        let nome = $('#name_login');
        let pwd = $('#pwd_login');
        let error_msg = document.getElementsByClassName('login_error_msg');
        let input_box = document.getElementsByClassName('input-box');

        // Função para informar que um nome foi introduzido
        nome.on('input', function () {
            if ($.trim(nome.val()) !== '') {
                error_msg[0].style.display = 'none';
                input_box[0].style.borderColor = 'green';
            }
        });

        if ($.trim(nome.val()) == '') {
            error_msg[0].style.display = 'block';
            input_box[0].style.borderColor = 'red';
            nome.val("");
            nome.focus();
            return false;
        }

        //Função para informar que foi introduzida uma password
        pwd.on('input', function () {
            if ($.trim(pwd.val()) !== "") {
                error_msg[1].style.display = 'none';
                input_box[1].style.borderColor = "green";
            }
        });

        if ($.trim(pwd.val()) == "") {
            error_msg[1].style.display = 'block';
            input_box[1].style.borderColor = "red";
            pwd.val("");
            pwd.focus();
            return false;
        }


    });

    //Função para garantir que não faltam dados na submissão do formulário de registo
    $('#form_signup').on('submit', function () {
        let nome = $('#name_signup');
        let email = $('#email_signup');
        let pwd1 = $('#pwd_signup');
        let pwd2 = $('#re_pwd_signup');

        let error_msg = document.getElementsByClassName('signup_error_msg');
        let input_box = document.getElementsByClassName('input-box');

        //Função para informar que um nome foi introduzido
        nome.on('input', function () {
            if ($.trim(nome.val()) !== '') {
                error_msg[0].style.display = 'none';
                input_box[2].style.borderColor = 'green';
            }
        });

        //Nome obrigatório
        if ($.trim(nome.val()) == "") {
            error_msg[0].style.display = "block";
            input_box[2].style.borderColor = 'red';
            nome.val("");
            nome.focus();
            return false;
        }

        //Função para informar que foi introduzido um email
        email.on('input', function () {
            if ($.trim(email.val()) !== "") {
                error_msg[1].style.display = 'none';
                input_box[3].style.borderColor = "green";
            }
        });

        //Email obrigatório
        if ($.trim(email.val()) == "") {
            error_msg[1].style.display = "block";
            input_box[3].style.borderColor = 'red';
            email.val("");
            email.focus();
            return false;
        }

        //Função para informar se foi introduzida uma password
        pwd1.on('input', function () {
            if ($.trim(pwd1.val()) !== "") {
                error_msg[2].style.display = 'none';
                input_box[4].style.borderColor = "green";
            }
        });

        //Password obrigatória
        if ($.trim(pwd1.val()) == "") {
            error_msg[2].style.display = "block";
            input_box[4].style.borderColor = 'red';
            pwd1.val("");
            pwd1.focus();
            return false;
        }

        //Função para informar se foi introduzida uma password de confirmação
        pwd2.on('input', function () {
            if ($.trim(pwd2.val()) !== "") {
                error_msg[3].style.display = 'none';
                input_box[5].style.borderColor = "green";
            }
        });

        //Validar passwords
        if (pwd1.val() != pwd2.val()) {
            error_msg[3].style.display = 'block';
            input_box[4].style.borderColor = 'red';
            input_box[5].style.borderColor = 'red';
            pwd1.val("");
            pwd2.val("");
            pwd1.focus();
            return false;
        }
    });


    // Remover o token da msg que vem por URL do PHP
    const url = new URL(window.location.href);

    if (url.searchParams.has('msg')) {

        // Remove o token
        url.searchParams.delete('msg');

        // Atualiza o URL sem recarregar a página
        history.replaceState(null, '', url);
    }


    // Se houver alguma mensagem a ser mostrada o backdrop das msgs é mostrado
    if (msg) {

        $('.msg_container').on('click', function (e) {
            e.stopPropagation();
        });

        $('#msg_backdrop').removeClass('hide').addClass('show');

        //Esconder o container das msgs quando se clica no background/backdrop
        $('#msg_backdrop').on('click', function () {
            $('#msg_backdrop').removeClass('show').addClass('hide');
        });

        //Esconder o container das msgs quando se clica na cruz
        $('#close_msg').on('click', function () {
            $('#msg_backdrop').removeClass('show').addClass('hide');
        });

        //Esconder o container das msgs quando se clica ENTER ou ESC
        $(document).on('keydown', function (e) {
            // Verificar se a tecla pressionada é 'Enter' ou 'Esc'
            if (e.key === 'Enter' || e.key === 'Escape') {
                e.preventDefault(); // Impedir o comportamento padrão da tecla
                $('#msg_backdrop').removeClass('show').addClass('hide');
            }
        });

        if (msg == 'login_success') {
            setTimeout(function () {
                window.location.href = 'index.php';
            }, 1500);

        }
        else if (msg == 'logout') {
            setTimeout(function () {
                window.location.href = 'index.php';
            }, 1500);

        }
        else if (msg == 'registo_success') {
            $('#signup_backdrop').removeClass('show').addClass('hide');
            setTimeout(function () {
                $('#msg_backdrop').removeClass('show').addClass('hide');
                $('#login_backdrop').removeClass('hide').addClass('show');
            }, 1500);

        }
        else if (msg == 'insert_success') {
            setTimeout(function () {
                window.location.href = 'insert_prod.php';
            }, 1500);
        }
    }

});


/********************************************************************************************************************************************/
/*                                                                      CHECK_SESSION                                                       */
/********************************************************************************************************************************************/

$(document).ready(function () {
    $('#add').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'check_session.php',
            method: 'GET',
            dataType: 'json',
            success: function (resposta) {
                if (resposta.logged_in) {
                    window.location.href = 'insert_prod.php#insert_product';
                }
                else {
                    $('#login_backdrop').removeClass('hide').addClass('show');
                    $('#login').removeClass('show').addClass('hide');
                    $('#msg_backdrop').removeClass('show').addClass('hide');
                }
            },
            error: function () {
                alert('Erro ao verificar a sessão.');
            }
        });
    });
});