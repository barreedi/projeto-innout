<?php

function requireValidSession(){//se for valido vai se nao volta tela de login//

$user = $_SESSION['user'];//sessao  user//
if(!isset($user)){//se nao tiver logado o user entra no header location//
    header('Location:login.php');
    exit();//aqui para finalizar//
}
}