<?php

class ValidationException extends AppException{

private $errors = [];
//este construct vai servi para mostrar mensagens de erro especifico como exemplo erro de email errado ou senha
public function __construct($errors = [],  
     $message = 'Erros de validacao', 
     $code = 0, $previous = null) {
     parent::__construct($message,$code, $previous);
     $this->errors = $errors;

}
public function getErrors(){
    return $this->errors;
}
public function get($att){//att significa atributos //mostrar erros relacionados a email e senha
    return $this->errors[$att];//atributos q foi passado como parametros
}

}