<?php
//se for valido vai se nao volta tela de login//
function requireValidSession($requiresAdmin = false){//comando requireadmin para so o admin ter acesso barra de relatorio

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;//sessao  user//
if(!isset($user)){//se nao tiver logado o user entra no header location//
    header('Location:login.php');
    exit();//aqui para finalizar//
}elseif($requiresAdmin && !$user->is_admin){//se os dois nao tiver setado

   addErrorMsg('Acesso negado!');//comando se nao for o administrador mensagem negado volta para tela abaixo
   header('Location: day_records.php');
   exit();

}
}