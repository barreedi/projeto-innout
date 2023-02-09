<?php
session_start();
requireValidSession(true);//para iniciar a sessao true se for admin

$exception = null;
$userData = [];//para atualizar botao amarelo

if (count($_POST) === 0 && isset($_GET['update'])) {//dados post qd preenche o formulario tras os dados
    $user = User::getOne(['id' => $_GET['update']]);//para carregar dados do usuario
    $userData = $user->getValues();//mostra os dados
    $userData['password'] = null;//so tras os dados sem a senha

} elseif (count($_POST) > 0) {//so entra no try se tiver algo dentro maior q zero
    try {
        $dbUser = new User($_POST);
        if ($dbUser->id) {//busca o id se for update ou insert abaixo
            $dbUser->update();
            addSuccessMsg('Usuário alterado com sucesso!');
            header('Location: users.php');//comando para voltar na tela de usuario depois q altera  usuario
            exit();
        } else {
            $dbUser->id = null;
            $dbUser->insert();
            addSuccessMsg('Usuário cadastrado com sucesso!');
        }
        $_POST = [];
    } catch (Exception $e) {
        $exception = $e;
    } finally {
        $userData = $_POST;//o post e para qd preencher o campo fica gravado no caso a variavel userdata esta fazendo isso
    }
}

loadTemplateView('save_user', $userData + ['exception' => $exception]);