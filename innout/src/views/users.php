<main class="content">
    <?php
        renderTitle(  //para o titulo da tela do usuario
            'Cadastro de Usuários',
            'Mantenha os dados dos usuários atualizados',
            'icofont-users'
        );

        include(TEMPLATE_PATH . "/messages.php");//para mostrar mensagem de exclusao na tela
    ?>

    <a class="btn btn-lg btn-primary mb-3"
        href="save_user.php">Novo Usuário</a><!--link do formulario para criar novo usuario-->

    <table class="table table-bordered table-striped table-hover">
        <thead><!--parte para mostrar os usuario-->
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Admissão</th>
            <th>Data de Desligamento</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr><!--pegando as variaveis para mostrar os usuario registrado-->
                    <td><?= $user->name ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->start_date ?></td>
                    <td><?= $user->end_date ?></td>
                    <td>
                        <!--aqui para salvar o usuario-->
                        <a href="save_user.php?update=<?= $user->id ?>" 
                            class="btn btn-warning rounded-circle mr-2"><!--esta class para botoes das acoes na tela circulo amarelo-->
                            <i class="icofont-edit"></i><!-- para o botao amarelo-->
                        </a>
                        <!-- parte para excluir o usuario q no caso pega o id do usuario-->
                        <a href="?delete=<?= $user->id ?>"
                            class="btn btn-danger rounded-circle"><!--circulo vermelho-->
                            <i class="icofont-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
</main>