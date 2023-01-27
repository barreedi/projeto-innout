
<main class="content">
    <?php
        renderTitle(//aqui a funcao render tilte q esta no leader.php
            'Registrar Ponto',//titulo
            'Mantenha seu ponto consistente!',//subtitulo
            'icofont-check-alt' //icone
        );
        include(TEMPLATE_PATH . "/messages.php");//aqui para aparecer mensagem ponto com sucesso
    ?>
    <div class="card">
        <div class="card-header">
            <h3><?= $today ?></h3>
            <p class="mb-0">Os batimentos efetuados hoje</p>
        </div>
        <div class="card-body">
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 1: <?= $workingHours->time1 ?? '---' ?></span>  <!--aqui para os batimentos na tela-->
                <span class="record">Saída 1: <?= $workingHours->time2 ?? '---' ?></span>
            </div>
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 2: <?= $workingHours->time3 ?? '---' ?></span>
                <span class="record">Saída 2: <?= $workingHours->time4 ?? '---' ?></span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="innout.php" class="btn btn-success btn-lg">
                <i class="icofont-check mr-1"></i>
                Bater o Ponto
            </a>
        </div>
    </div>

    <!--btn btn-danger ml-3 para o botao simular ponto calcula as horas  e mostra lateral esquerda em baixo-->
    <form class="mt-5" action="innout.php" method="post">
        <div class="input-group no-border">
            <input type="text" name="forcedTime" class="form-control" 
                placeholder = "Informe a hora para simular o batimento">
            <button class="btn btn-danger ml-3"><!--para o botao simular ponto-->
                Simular Ponto
            </button>
        </div>
    </form>

</main>