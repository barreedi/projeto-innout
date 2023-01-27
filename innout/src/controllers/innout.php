<?php

session_start();//innout serve para qd passar o ponto aparece a hora de entrada,saida
requireValidSession();

loadModel('WorkingHours');//chamou o workinghours 

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));//pega os registros do banco

try {//esta parte para qd exeder a qt d passagem de ponto
   $currentTime = @strftime('%H:%M:%S', time());

    if (isset($_POST['forcedTime'])) {//faz parte do botao simular ponto o forcedtime
     $currentTime = $_POST['forcedTime'];//para calcular as horas exemplo digitar entrada e saida qt deu
   }
    $records->innout($currentTime);//inserer o registro no banco de dados
    addSuccessMsg('Ponto inserido com sucesso!');

} catch (AppException $e) {//mensagem de erro para qd passar dos batimentos de ponto
  addErrorMsg($e->getMessage());
}

header('Location: day_records.php');//vai direcionar para um controler q e o day_records.php

