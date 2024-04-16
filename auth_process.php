<?php
    require_once('globals.php');
    require_once('conection.php');
    require_once('models/User.php');
    require_once('models/Message.php');
    require_once('dao/UserDAO.php');

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    // Resgata o tipo do formulário
    $type = filter_input(INPUT_POST, 'type');

    // Verifica o tipo de formulário
    if($type === 'register'){
        $name = filter_input(INPUT_POST, 'name');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $confirmpassword = filter_input(INPUT_POST, 'confirmpassword');

        // Verificação de dados mínima
        if($name && $lastname && $email && $password){
            // Verificando se as senhas batem
            if($password === $confirmpassword){
                // Verificando se o e-mail já está cadastrado no sistema
                if($userDao->findByEmail($email) === false){
                    $user = new User();

                    // Criação de token e senha
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword;
                    $user->token = $userToken;

                    $auth = true;

                    $userDao->create($user, $auth);
                }
                else{
                    $message->setMessage('Usuário já cadastro, tente outro e-mail', 'danger', 'back');
                }
            }
            else{
                $message->setMessage('As senhas não são iguais', 'danger', 'back');
            }
        }
        else{
            // Envia mensagem de erro "dados faltantes"
            $message->setMessage('Por favor preencha todos os campos', 'danger', 'back');
        }
    }
    else if($type === 'login'){
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        if($userDao->authenticateUser($email, $password)){
            $message->setMessage('Seja bem-vindo!', 'success', 'editprofile.php');
        }
        else{
            $message->setMessage('E-mail ou  senha incorretos', 'danger', 'back');
        }
    }
    else{
        $message->setMessage('Informações inválidas!', 'danger', 'index.php');
    }