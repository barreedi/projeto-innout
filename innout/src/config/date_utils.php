<?php
//codigo para compara horas trabalho entrada saida
//loadModel('WorkingHours');//loadmodel para carregar esta pagina

//esta parte para comparam datas se e final de semana se dia anterior ou outro dia//
function getDateAsDateTime($date) {// funcao date
    return is_string($date) ? new DateTime($date) : $date;//retorna um string ou uma data

}
function isWeekend($date) {//aqui se e final de semana
    $inputDate = getDateAsDateTime($date);
    return $inputDate->format('N') >= 6;
}

function isBefore($date1, $date2) {//funcao para comparar data maior ou menor proximo dia
    $inputDate1 = getDateAsDateTime($date1);
    $inputDate2 = getDateAsDateTime($date2);
    return $inputDate1 <= $inputDate2;
}

function getNextDay($date) {//proximo dia
    $inputDate = getDateAsDateTime($date);
    $inputDate->modify('+1 day');//modifica mais um dia
    return $inputDate;
}
//abaixo para comparar as horas tempo de almoco somar das horas
function sumIntervals($interval1, $interval2) {//para somar os intervalos das horas trabalhadas
    $date = new DateTime('00:00:00');//vai pegar a hora atual e zerar
    $date->add($interval1);//vai adicionar no os intervalo este e o 1
    $date->add($interval2);//intervalo do 2
    return (new DateTime('00:00:00'))->diff($date);//retorna a soma dos dois intervalos
}
function subtractIntervals($interval1, $interval2) {//para subtrair os intervalos das horas trabalhadas
    $date = new DateTime('00:00:00');//vai pegar a hora atual e zerar data de referencia
    $date->add($interval1);//vai adicionar no os intervalo este e o 1
    $date->sub($interval2);//intervalo do 2
    return (new DateTime('00:00:00'))->diff($date);//retorna a subtracao dos dois intervalos

}
function getDateFromInterval($interval){
    return new DateTimeImmutable($interval->format('%H:%i:%s'));
}
function getDateFromString($str){
    return DateTimeImmutable::createFromFormat('H:i:s',$str);
}
function getFirstDayOfMonth($date) {
    $time = getDateAsDateTime($date)->getTimestamp();
    return new DateTime(date('Y-m-1', $time));
}

function getLastDayOfMonth($date) {
    $time = getDateAsDateTime($date)->getTimestamp();
    return new DateTime(date('Y-m-t', $time));
}
function getSecondsFromDateInterval($interval) {
    $d1 = new DateTimeImmutable();
    $d2 = $d1->add($interval);//vai gerar uma nova data
    return $d2->getTimestamp() - $d1->getTimestamp();
}
function isPastWorkday($date) {//um dia trabalho no passado
    return !isWeekend($date) && isBefore($date, new DateTime());
}
 function getTimeStringFromSeconds($seconds){//esta funcao para calcular os segundos dia d trabalho
  $h = intdiv($seconds, 3600);//vai dividir os segundos por 3600s  q e uma hora em segundos
  $m = intdiv($seconds % 3600, 60);//vai dividir o resto da divisao de cima com 60m
  $s = $seconds - ($h * 3600) - ($m * 60);//calcular qt de segundos q seconds  e total ai vai subtrair com h e m
   return sprintf('%2d:%02d:%02d', $h,$m,$s) ;//retorna formato da hora,m e s.
}

function formatDateWithLocale($date, $pattern) {//
    $time = getDateAsDateTime($date)->getTimestamp();
    return @strftime($pattern, $time);
}