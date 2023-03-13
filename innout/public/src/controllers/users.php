<?php
session_start();
requireValidSession(true);//true comando se for admin


$exception = null;
if(isset($_GET['delete'])) {//se estiver setado o delete vai excluir usuario do banco
    try {
        User::deleteById($_GET['delete']);//esta parte tela usuario e novo usuario para excluir
        addSuccessMsg('Usuário excluído com sucesso.');
    } catch(Exception $e) {
        if(stripos($e->getMessage(), 'FOREIGN KEY')) {//se cair nesta sessao  nao pode excluir o usuario
            addErrorMsg('Não é possível excluir o usuário com registros de ponto.');
        } else {
            $exception = $e;
        }
    }
}

$users = User::get();//para carregar o usuario
foreach($users as $user) {
    $user->start_date = (new DateTime($user->start_date))->format('d/m/Y');  // esta parte para mostrar datas estilo brasil 
    if($user->end_date) {
        $user->end_date = (new DateTime($user->end_date))->format('d/m/Y');//esta data para parte do desligamento formato brasil
    }
}

loadTemplateView('users', [//interface grafica
    'users' => $users,
    'exception' => $exception
]);