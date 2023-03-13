

<main class ="content"><!--// aqui formatacao da tela os botoes -->
    

<?php


 renderTitle(//renderizar o titulo via mostrar na tela cabecalho
    'Relatorio Mensal',
    'Acompanhe seu saldo de horas',
    'icofont-ui-calendar');

?>
<div>            
<form class= "mb-4"  action="#" method="post"><!--parte para botao de administrador na tela-->
        <div class="input-group">
            <!--esta parte do adminitrador se for vai mostrar esta parte de baixo-->
            <?php if($user->is_admin): ?>
             <select name = "user" class ="form-control mr-2" placeholder = "selecione o usuario...">
               <option value ="">Selecione o usuario </option>
               <?php
                    foreach($users as $key => $user) {//para selecionar o usuario campos de pesquisa relatorio mensal
                        $selected = $user->id === $selectedUserId ? 'selected': '';
                       echo "<option value='{$user->id}'{$selected}>{$user->name}</option>";
                    }  
                    ?>
                </select><!--ate aqui parte do administrador-->
                <?php endif ?>
            <!--esta parte para mostrar barra buscar o relatorio de pontos  dos funcionario-->
                <select name = "period" class ="form-control " placeholder = "selecione o período...">
                <?php
                    foreach($periods as $key => $month) {//comando para selecionar datas marcacao de pontos
                        $selected = $key === $selectedPeriod ? 'selected': '';
                    echo "<option value='{$key}'{$selected}>{$month}</option>";
                    }
                    ?>
                </select>
                <button class="btn btn-primary ml-2"><!--para botao de lopa para pesquisa cor azul-->
                    <i class="icofont-search"></i>
                </button>
        </div>
    </form>
    <table class ="table table-bordered table-striped table-hover"><!--class formatar  a tela inteira abaixo-->
        <thead>
                <th>Dia</th>
                <th>Entrada 1</th>
                <th>Saida 1</th>
                <th>Entrada 2</th>
                <th>Saida 2</th>
                <th>Saldo</th>  
        </thead>
        <tbody>
            <?php 
               foreach($report as $registry): ?>  <!--reportar e mostrar os registros para preencher as informacoes-->
               <tr>
                   <td><?=utf8_encode(formatDateWithLocale($registry->work_date,'%A,%d de %B de %Y') )?></td><!--imprimir a informacao primeiro valor-->
                   <td><?=$registry->time1 ?></td><!-- os registros na tela-->
                   <td><?=$registry->time2 ?></td>
                   <td><?=$registry->time3 ?></td>
                   <td><?=$registry->time4 ?></td>
                   <td><?=$registry->getBalance() ?></td>
               </tr>
               <?php endforeach ?>
               <tr class = "bg-primary text-white"><!--class para deixar embaixo azul dentro branco-->
                <td>Horas Trabalhadas</td>
                <td colspan="3"><?= $sumOfWorkedTime ?></td><!--colspan para deixar o valor no local do saldo-->
                <td>Saldo Mensal</td>
                <td><?= $balance ?></td>
               </tr>
           </tbody>
       </table>
    </div>
</main>
