<?php

//esta parte para os desenvolvedores para ter acesso
//limpar os batimentos de ponto na tela

loadModel('WorkingHours'); //chamando class model trabalho

Database::executeSQL('DELETE FROM  working_hours');//para voltar o banco no estado original
Database::executeSQL('DELETE FROM  users WHERE id > 5');//aqui se maior q 5 id ele deleta banco de dados//

//funcao para mostrar quem trabalhou menor ou mais ou regular
function getDayTemplateByOdds($regularRate, $extraRate, $lazyRate) {
// template para horas trabalhadas e dia trabalhado
$regularDayTemplate = [
    'time1' => '08:00:00',
    'time2' => '12:00:00',
    'time3' => '13:00:00',
    'time4' => '17:00:00',
    'worked_time'=> DAILY_TIME 
    
];
//aqui de horas extras
$extraHourDayTemplate = [
    'time1' => '08:00:00',
    'time2' => '12:00:00',
    'time3' => '13:00:00',
    'time4' => '18:00:00',
    'worked_time'=> DAILY_TIME + 3600
    
];
//aqui trabalhou menos no dia
$lazyDayTemplate = [
    'time1' => '08:00:00',
    'time2' => '12:00:00',
    'time3' => '13:00:00',
    'time4' => '17:00:00',
    'worked_time'=> DAILY_TIME - 1800
    
];
$value = rand(0,100); //mostrar um valor aleatorio para horas trabalhadas

if($value <= $regularRate) { // se o valor q e rand 0 100, for menor q template regular retorna template regular
    return $regularDayTemplate;
}elseif($value <= $regularRate + $extraRate){
       return $extraHourDayTemplate;// retorna horas extras
}else {
    return $lazyDayTemplate;
}
}

//aqui vvmos definir as datas se e final semana ou nao meio da semana

 function populateWorkingHours($userId, $initialDate, $regularRate, $extraRate, $lazyRate) {//aqui pegando usuario inicil a data entrada no banco
    $currentDate = $initialDate;//data atual recebe a data inicial
    $yesterday = new DateTime();//colocando data de hoje no banco
    $yesterday->modify('-1 day');
    $columns = ['user_id' => $userId, 'work_date' => $currentDate];//a coluna vai todos os datas do banco

    while(isBefore($currentDate, $yesterday)) {//enquanto currentDate for antes d today fica no laco
       
        if(!isWeekend($currentDate)) {//se nao for final de semana faca
            $template = getDayTemplateByOdds($regularRate, $extraRate, $lazyRate);//vai pegar um template horas trabalha ou horas extras
            $columns = array_merge($columns, $template);//inserindo no banco estes dados
            $workingHours = new WorkingHours($columns);
            $workingHours->insert();
        }
    $currentDate = getNextDay($currentDate)->format('Y-m-d');
        $columns['work_date'] = $currentDate;//atualiza as datas no banco
    }
}

$lastMonth = strtotime('first day of last month');//para atualizar os dias do banco

populateWorkingHours(1,date('Y-m-1'),70,20,10);//preenchendo o banco com os dados
populateWorkingHours(3,date('Y-m-d', $lastMonth),20,75,5);//d e o dia atual
populateWorkingHours(4,date('Y-m-d', $lastMonth),20,10,70);//os numeros sao porcentagem de chance de fazer horas extra ou nao


echo 'tudo certo';