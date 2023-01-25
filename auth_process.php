<?php

require_once ("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");    

$message = new Message($BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);


// Resgata o ipo do formulário
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
                echo "Nenhum usuário foi encontrado.";

            }else{

                // Enviar msg de erro, usuário já existe
                $message->setMessage("Por favor verifique, email já cadastrado.", "error", "back");

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

}
