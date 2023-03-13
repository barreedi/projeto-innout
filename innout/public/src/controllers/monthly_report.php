<?php
// este codigo para acessar  relatorio mensal

session_start();
requireValidSession();

$currentDate = new DateTime();//(new DateTime) para pegar hora atual
$user = $_SESSION['user'];

$selectedUserId = $user->id;//codigo para usuario administrador
$users = null;
if($user->is_admin) {//usuario administrador

    $users = User::get();//para selecionar o usuario area de relatorio mensal
    $selectedUserId = isset($_POST['user']) && $_POST['user'] ? $_POST['user'] : $user->id;
}

$selectedPeriod = isset($_POST['period']) && $_POST['period'] ? $_POST['period'] : $currentDate->format('Y-m');
$periods = []; //esta parte para selecionar os horarios dos funcionario hora q baterao ponto e sairam
for($yearDiff = 0; $yearDiff <= 2; $yearDiff++) {//for contagem de anos
    $year = date('Y') - $yearDiff;//vai subtrair o ano e a diferencia de ano q e igual 0  menor q 2
    for($month = 12; $month >= 1; $month--) { //for contagem de mes
        $date = new DateTime("{$year}-{$month}-1");//aqui valor do dia ano e mes
        $periods[$date->format('Y-m')] = @strftime('%B de %Y', $date->getTimestamp());
    }
}

$registries = WorkingHours::getMonthlyReport($selectedUserId, $selectedPeriod);

$report = [];
$workDay = 0;
$sumOfWorkedTime = 0;
$lastDay = getLastDayOfMonth($selectedPeriod)->format('d');//ultimo dia do mes para fazer um laco for

for($day = 1; $day <= $lastDay; $day++) {//para percorrer os dias
    $date = $selectedPeriod . '-' . sprintf('%02d', $day);
    $registry = isset($registries[$date]) && $registries[$date]? $registries[$date]: null;
  

  
    if(isPastWorkday($date)) $workDay++;

    if(isset($registry)) {
        $sumOfWorkedTime += $registry->worked_time;
        array_push($report, $registry);
    } else {
        array_push($report, new WorkingHours(['work_date' => $date,'worked_time' => 0 ]));
    }
}

$expectedTime = $workDay * DAILY_TIME;//aqui esta multiplicando quantidade de dia trabalhado vezes a constante daily time
$balance = getTimeStringFromSeconds(abs($sumOfWorkedTime - $expectedTime));//qt de trabalho menos o esperado do dia de trabalho
$sign = ($sumOfWorkedTime >= $expectedTime) ? '+' : '-';//se horas trabalhadas for maior tempo esperado

loadTemplateView('monthly_report', [
    'report' => $report,
    'sumOfWorkedTime' => getTimeStringFromSeconds($sumOfWorkedTime),//qt de segundos q trabalhou no mes
    'balance' => "{$sign}{$balance}",//qt de saldo do funcionario qt para menos ou para mais
    'selectedPeriod' => $selectedPeriod,
    'periods' => $periods,//para mostrar os meses dentro da barra onde buscar a marcacao de ponto dos funcionario
    'selectedUserId' => $selectedUserId,//aqui para usuarios selecionados relatorio mensal
   'users' => $users,
]);
