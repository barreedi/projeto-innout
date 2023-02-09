
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/comum.css"><!--link formatacao da pagina-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>In  N' Out </title>
    
</head>
<body>
    <!--aqui estamos criando o cabecalho da pagina-->
   <form class="form-login" action = "#" method ="post"><!--formulario com post este ligado com login da pasta controller-->
     <div class= "login-card card"><!--class card´é do bootstrap-->
        <div class="card-header"> <!-- div.class enter-->
       <i class ="icofont-travelling mr-2"></i><!-- esta parte para colocar os icones homem correndo o mr 2 para dar espaco boneco-->
       <span class = "font-weight-light">In</span>
       <span class = "font-weight-bold mr-2 ml-2">N'</span><!-- desta forma vai aparecer o nome no meio dos bonecos mr,ml ou mx para dar espaco-->
       <span class = "font-weight-light">Out</span>
       <i class ="icofont-runner-alt-1 ml-1"></i><!-- ml-2 lado direito bonecos dar espaco-->
        </div>
        <div class="card-body">
            <?php include(TEMPLATE_PATH . '/messages.php') ?><!--para mostrar mensagem de erro em cima do login tem q colocar este include aqui messages.php-->
            <div class="form-group">
                <label for = "email">E-mail</label>
                <input type="email" id="email" name="email"                                        
                class = "form-control <?=isset($errors['email'])  ? 'is-invalid' : ''?>"
                value = "<?= isset($email) ? $email : ''?>"
                placeholder ="informe o e-mail" autofocus>
                <div class = "invalid-feedback"><?=$errors['email'] ?>
            </div>                  <!--para manter o email gravado o value acrescentado o post ou vazio-->
            </div>                  <!--$exception->get('email')aqui para qd nao digitar o email ficar barra vermelha-->
                                    <!--invalid-feedback para mostra a mensagem campo obrigatorio em baixo em vermelho-->
            <div class="form-group">
                <label for = "password">Senha</label>
                <input type="password" id="password" name="password"
                class ="form-control <?= isset($errors['password']) ? 'is-invalid': ''?>" 
                placeholder="informe a senha">
                <div class = "invalid-feedback"><?=$errors['password']?>
            </div>
            </div>
            
            <div class="card-footer"><!--o card vem do bootstrap-->
                <button class = "btn btn-lg btn-primary">Entrar</button>
            </div>
         </div>
     </div>
   </form> 

</body>
</html>
