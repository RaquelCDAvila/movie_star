<?php

require_once ("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");    

$message = new Message($BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);


// Resgata o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// Verificação do tipo de formulário
if($type === "register"){

    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    // Verificação de dados mínimos
    if($name && $lastname && $email && $password){

        //Verificar se as senhas estão corretas
        if($password === $confirmpassword){

            //Verificar se o email já está cadastrado no sistema
            if($userDAO->findByEmail($email) === false){
                
                $user = new User();
                
                //Criação de token e senha
                $userToken = $user->generateToken();
                //$finalPassword = password_hash($password, PASSWORD_DEFAULT);
                $finalPassword = $user->generatePassword($password);

                
                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;
                
                $auth = true;

                $userDAO->create($user, $auth);
                
            }else{

                // Enviar msg de erro, usuário já existe
                $message->setMessage("Usuário já cadastrado, por favor, tente outro e-mail.", "error", "back");

            }

        }else{

            // Enviar msg de erro, senhas não iguais
            $message->setMessage("Por favor verifique, as senhas não são iguais.", "error", "back");

        }

    } else {
        // Enviar msg de erro, de dados faltantes
        $message->setMessage("Por favor preencha todos os campos.", "error", "back");
    }
} else if($type === "login"){

    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    // Tentar autenciar usuário
    if($userDAO->authenticateUser($email, $password)) {
        $message->setMessage("Seja Bem-vindo!", "success", "editprofile.php");

    } else {
        // Redireciona usuário caso não consiga identificar
        $message->setMessage("Usuários e/ou senha incorretos.", "error", "back");
    }
} else{
    $message->setMessage("Informações incorretas.", "error", "back");
}
