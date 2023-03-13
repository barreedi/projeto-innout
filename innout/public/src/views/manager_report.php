
<main class = "content "><!--este codigo para o template de relatorio gerencial-->
  <?php
            // definir o titulo da tela o rendertitle
   renderTitle(
   'Relatorio Gerencial',
   'Resumo das horas trabalhadas dos funcionarios',
   'icofont-chart-histogram'//este pra o icone da tela
);
  ?>
<div class = "summary-boxes">
    <div class ="summary-box bg-primary"><!--o css da caixinha azul-->
        <i class = "icofont-users"></i>
        <p class ="title">Qtde de funcionarios</p><!--titulo da caixa do sumario-->
        <h3 class ="value"><?=$activeUsersCount ?></h3><!--valor da vai ser dentro da caixinha-->
    </div>

<div class = "summary-box bg-danger">
        <i class = "icofont-patient-bed"></i>
        <p class ="title">Faltas</p><!--titulo da caixa do sumario-->
        <h3 class ="value"><?=count($absentUsers) ?></h3><!--valor vai ser dentro da caixinha funcionario ausente-->
    </div>
    <div class = "summary-box bg-success">
        <i class = "icofont-sand-clock"></i>
        <p class ="title">Qts de horas do mes</p><!--titulo da caixa do sumario-->
        <h3 class ="value"><?= $hoursInMonth  ?></h3><!--valor  vai ser dentro da caixinha horas trabalhadas dos funcionario-->
    </div>
</div>
<?php if(count($absentUsers) > 0): ?><!--so vai executar se tiver funcionario faltosos-->
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-tilte">Faltosos do dia</h4>
                <p class="card-category mb-0">Relacao dos funcionarios que ainda nao bateram o ponto</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <th>Nome</th><!--para nomes dos funcionarios ausente-->
                    </thead>
                    <tbody>
                        <?php foreach($absentUsers as $name): ?><!--para pegar a lista dos funcionario ausente-->
                            <tr>
                                <td><?= $name ?></td><!--vai mostrar os nomes dos funcionario ausentes-->
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php endif ?> 
</main>











