<?php
loadModel('Model');
class WorkingHours extends Model {//uma class jornada de trabalho 
    protected static $tableName = 'working_hours';//criando uma tabela sobre jornada de trabalho
    protected static $columns = [
        'id',
        'user_id',
        'work_date',
        'time1',//batimento pela manha
        'time2',//hora do almoco
        'time3',//volta do almoco
        'time4',//saida
        'worked_time'
    ];

    public static function loadFromUserAndDate($userId, $workDate) {//vai carregar jornada de trabalho atraves do usuario no banco
        $registry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);//aqui pega o registro do banco

        if(!$registry) {//se nao tiver presente o registro faca
            $registry = new WorkingHours([
                'user_id' => $userId,//coloca id da pessoa
                'work_date' => $workDate, // dia de trabalho
                'worked_time' => 0  //quantidade de horas trabalhadas
            ]);
        }

        return $registry; //retorna o registro pegou do banco
    }

    public function getNextTime() {//se tiver batido ponto passa para outro time 
        if(!$this->time1) return 'time1';//se nao tiver setado retorna o ponto 1 primeiro do dia
        if(!$this->time2) return 'time2';
        if(!$this->time3) return 'time3';
        if(!$this->time4) return 'time4';
        return null;//mostra q nenhum batimento precisa ser feito
    }

    public function getActiveClock() {//
        $nextTime = $this->getNextTime();//
        if($nextTime === 'time1' || $nextTime === 'time3') {//
            return 'exitTime';
        } elseif($nextTime === 'time2' || $nextTime === 'time4') {
            return 'workedInterval';
        } else {
            return null;
        }
    }

    public function innout($time) {//AQUI QD VC BATE MAIS DE 4 VEZ O PONTO ESTA FUNCAO
        $timeColumn = $this->getNextTime();
        if(!$timeColumn) {//se nao tiver definido o timecolumn todos os batimentos foram executados
            throw new AppException("Você já fez os 4 batimentos do dia!");
            //aqui vai mostra foi batidos os batimentos e limpa a tela para fazer outros batimentos
      
    }
    

    
        $this->$timeColumn = $time;
       $this->worked_time = getSecondsFromDateInterval($this->getWorkedInterval());
        if($this->id) { // se id estiver setado significa tem q fazer um update
            $this->update();//alterando um arquivo
        } else {
            $this->insert();//aqui e inserindo um arquivo
        }
    }
     function getWorkedInterval() {//esta funcao para intervalo de tempo lado esq da tela canto de baixo
        [$t1, $t2, $t3, $t4] = $this->getTimes();//a partir desse 4 horario vai definir se os 4 esta setado para fazer calculo

     // os (PTOS) E A DOCUMENTACAO DE PERIODO DE TEMPO Q ZERO E S SIGNIFICA ZERO SEGUNDOS
       $part1 = new DateInterval('PT0S');//vai ser periodo do dia de manha
       $part2 = new DateInterval('PT0S');//vai ser periodo da tarde

        if($t1) $part1 = $t1->diff(new DateTime());//O $T1 sign batimento o DIFF  a diferenca com a hora  atual q é new datetime q é hora atual.
        if($t2) $part1 = $t1->diff($t2);//se o t2 estiver setado part1 igual a soma t1 com t2
        if($t3) $part2 = $t3->diff(new DateTime());
        if($t4) $part2 = $t3->diff($t4);

        return sumIntervals($part1, $part2);//aqui somado qt trabalho de manha ate a tarde
     }

     function getLunchInterval() {//funcao na batida da hora do almoco
        [, $t2, $t3,] = $this->getTimes();//so pega o t2 2 t3 pq hora do almoco
        $lunchInterval = new DateInterval('PT0S');

        if($t2) $lunchInterval = $t2->diff(new DateTime());
        if($t3) $lunchInterval = $t2->diff($t3);//t2 iniciou do almoco e t3 final do almoco

        return $lunchInterval;
    }
       function getExitTime() {//funcao para calcular a saida do trabalho
        [$t1,,, $t4] = $this->getTimes();//vai calcular so a saida
        $workday = DateInterval::createFromDateString('8 hours');//o periodo tempo de 8 o calculo
         
        if(!$t1) {//aqui se nao bateu o primeiro ponto
            return (new DateTimeImmutable())->add($workday);//pega a hora atual soma com 8 horas
        } elseif($t4) {
            return $t4;
        } else {
            $total = sumIntervals($workday, $this->getLunchInterval());//soma hora trabalhada com do almoco
            return $t1->add($total);
        }
    }
    function getBalance() {
        if(!$this->time1 && !isPastWorkday($this->work_date)) return '';
        if($this->worked_time == DAILY_TIME) return '-';

        $balance = $this->worked_time - DAILY_TIME;
        $balanceString = getTimeStringFromSeconds(abs($balance));//abs valor absoluto
        $sign = $this->worked_time >= DAILY_TIME ? '+' : '-';
        return "{$sign}{$balanceString}";
    }
    public static function getAbsentUsers() {
        $today = new DateTime();//para saber quem nao bateu pontos new Datetime() data de hoje
        $result = Database::getResultFromQuery("
            SELECT name FROM users
            WHERE end_date is NULL 
            AND id NOT IN (
                SELECT user_id FROM working_hours
                WHERE work_date = '{$today->format('Y-m-d')}'
                AND time1 IS NOT NULL
            )
        ");//codigo acima pegando todos os usuarios q baterao ponto
        
        $absentUsers = [];
        if($result->num_rows > 0) {//se isso for maior q zero faca
            while($row = $result->fetch_assoc()) {
                array_push($absentUsers, $row['name']);
            }
        }

        return $absentUsers;//retorna os usuario q estao ausentes do dia marcacao de ponto
    } 
    //para todas horas trabalhadas do mes dos funcionarios
    public static function getWorkedTimeInMonth($yearAndMonth) {//do mes
        $startDate = (new DateTime("{$yearAndMonth}-1"))->format('Y-m-d');//datas de inicio
        $endDate = getLastDayOfMonth($yearAndMonth)->format('Y-m-d');//datas do final
        $result = static::getResultSetFromSelect([
            'raw' => "work_date BETWEEN '{$startDate}' AND '{$endDate}'"//vai filtrar
        ], "sum(worked_time) as sum");//somatoria 
        return $result->fetch_assoc()['sum'];//retorna a soma
    }

    public static function getMonthlyReport($userId,$date){//para um relatorio mensal
        $registries = [];
        $startDate = getFirstDayOfMonth($date)->format('Y-m-d');
        $endDate = getLastDayOfMonth($date)->format('Y-m-d');

        $result = static::getResultSetFromSelect([
          'user_id'=> $userId,'raw'=> "work_date between ' {$startDate}' AND '{$endDate}'"]);

          if($result){
            while($row = $result->fetch_assoc() ){
                $registries[$row ['work_date']] = new WorkingHours($row);
            }
          }
          return $registries ;
    }


      private function getTimes() {//private nao consegue acessa na tela
        $times = [];
       //para mostra as horas da marcacao de ponto das horas trabalhadas tempo de cada hora
        $this->time1 ? array_push($times, getDateFromString($this->time1)) : array_push($times, null);
        $this->time2 ? array_push($times, getDateFromString($this->time2)) : array_push($times, null);
        $this->time3 ? array_push($times, getDateFromString($this->time3)) : array_push($times, null);
        $this->time4 ? array_push($times, getDateFromString($this->time4)) : array_push($times, null);

        return $times;
    }
}
 