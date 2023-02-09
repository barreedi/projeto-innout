
<main class="content"> <!--esta parte pega o container de dentro tela nao e as laterais-->
    <?php
        renderTitle(//aqui a funcao render tilte q esta no leader.php
            'Registrar Ponto',//titulo
            'Mantenha seu ponto consistente!',//subtitulo
            'icofont-check-alt' //icone
        );
        include(TEMPLATE_PATH . "/messages.php");//aqui para aparecer mensagem ponto com sucesso
    ?>
    <div class="card"><!--card para sobriamento no registrar ponto e ponto consistente-->
        <div class="card-header">
            <h3><?= $today ?></h3><!--variavel today pra data na tela atualizada-->
            <p class="mb-0">Os batimentos efetuados hoje</p><!--mb-0 para diminuir o container -->
        </div>
        <div class="card-body">
            <div class="d-flex m-5 justify-content-around"><!--usando d-flex m-5 para espacamento-->
                <span class="record">Entrada 1: <?= $workingHours->time1 ?? '---' ?></span>  <!--aqui para os batimentos na tela-->
                <span class="record">Saída 1: <?= $workingHours->time2 ?? '---' ?></span><!-- time1 mostra na tela o horario -->
            </div>
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 2: <?= $workingHours->time3 ?? '---' ?></span>
                <span class="record">Saída 2: <?= $workingHours->time4 ?? '---' ?></span>
            </div>
        </div><!--esta class com d-flex justify-content-center sao todas do bootstrap-->
        <div class="card-footer d-flex justify-content-center"><!--para criar um botao bater ponto-->
            <a href="innout.php" class="btn btn-success btn-lg"><!--class deixa botao verde bater ponto-->
                <i class="icofont-check mr-1"></i><!--observacao repare q esta chamando no href o innout.php-->
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