<?php
session_start();
requireValidSession();
//loadModel('Login');

loadModel('WorkingHours'); 

$date = (new Datetime())->getTimestamp();
$today = @strftime('%d de %B de %Y', $date);//@ sublime warning
$user = $_SESSION['user'];//colocando o usuario na sessao//
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

loadTemplateView('day_records', [
    'today' => $today,
    'records'=> $records 
]);


//aqui load é a funcao q ele criou loader.php assim ele conecta as pasta no caso templateview day_records.php pasta view
//oadTemplateView('day_records');
/*

//session_start();//abrindo um session//
//$exception = null;//so vai mostra mensg do exception se estiver null
$exception =  null;
                        //se o contador post for maior q zero cria um requisicao para mudar senha
if(count($_POST) > 0 ){ //aqui o post da pasta views login.php vai conferir login e senha se tiver entra
    $login = new Login($_POST); // POST  E ASSOCIATIVO aqui login recebe os dados do post login e senha

    try{
        $user = $login->checkLogin();//criou user variavel se login vai checar o login se esta correto se esta logado
        $_SESSION['user'] = $user;//colocando o usuario na sessao//
        header("Location: day_records.php");
        exit();

    }catch(AppException $e){//aqui vai conectar com messagem erradas tipo email e senha

        $exception = $e;//mostrar a mensagem
        //echo $e->getMessage();//$e->getMessage este atributo para mostrar as mensg se usuario esta logado ou nao 

    }
}
                   //colocou mais o exception uma chave q esta dentro da views
loadView('login', $_POST + ['exception'=> $exception]);//para ficar o email gravado no login coloca o POST AQUI//
*/