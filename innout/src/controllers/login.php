<?php
loadModel('Login');
session_start();//abrindo um session//
$exception = null;//so vai mostra mensg do exception se estiver null

                        //se o contador post for maior q zero cria um requisicao para mudar senha
if(count($_POST) > 0 ){ //aqui o post da pasta views login.php vai conferir login e senha se tiver entra

    $login = new Login($_POST); // POST  E ASSOCIATIVO aqui login recebe os dados do post login e senha

    
    try{
        $user = $login->checkLogin();//criou user variavel se login vai checar o login se esta correto se esta logado
    
        $_SESSION['user'] = $user;//colocando o usuario na sessao//
       header("Location: day_records.php");//direcionar para pasta view/template/day_reocords.php
        //exit();

    }catch(AppException $e){//aqui vai conectar com messagem erradas tipo email e senha
       // $exception =$e;
    }
}

loadView('login',$_POST + ['exception'=> $exception]);//para ficar o email gravado no login coloca o POST AQUI//);
