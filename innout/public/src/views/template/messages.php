<?php

 $errors = [];//arrei vazio dos erros todos se tiver erros mostra se ele esta vazio

 
if(isset($_SESSION['message'])){//se estiver setado mostra mg PONTO INSERIDO COM SUCESSO
   $message = $_SESSION['message'];//mostra so uma vez a mg
   unset($_SESSION['message']);//unset para limpar  a sessao significa foi com sucesso depois marcou ponto

}elseif(isset($exception)) {//para gerar uma mensagem para erro ou adivertencia
     $message = ['type'=> 'error',
     'message'=>$exception->getMessage() ];//exception com atributo getmessage para gerar a mensagem

  if(get_class($exception) === 'ValidationException') { //coloca os erros aqui em validationexception
      $errors = $exception->getErrors(); //os erros vai ficar nesta variavel errors

}
  }

$alertType = '';//variavel vazia

if(isset($message['type']) && $message['type'] === 'error'){//se message type for erro 
   $alertType = 'danger';//imprimi este erro

}else {
   $alertType = 'success';
}
?>

<?php if(isset($message) && $message):?><!--para mostrar a mensagem no logi-->
   <div role="alert"
    class ="my-3 alert alert-<?= $alertType ?>">
       <?=$message['message'] ?>

</div>
<?php  endif?>

