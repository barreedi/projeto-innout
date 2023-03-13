<?php

class User extends Model {//aqui pega a tabela do banco usuario para acessa //
    protected static $tableName = 'users';
    protected static $columns = [
    
        'id',	
        'name',
        'password',		
        'email',	
        'start_date',			
        'end_date',		
        'is_admin',		
    
    ];

    public static function getActiveUsersCount() {//para saber os funcionarios ativo q precisa trabalhar naquele dia
        return static::getCount(['raw' => 'end_date IS NULL']);
    }

  
    public function insert() {//parte do usuario na tela
        $this->validate();//comando para validar o erro na tela se nao preencher os campos erro
        $this->is_admin = $this->is_admin ? 1 : 0;
        if(!$this->end_date) $this->end_date = null;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::insert();
    }

    public function update() {
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;
        if(!$this->end_date) $this->end_date = null;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::update();
    }
  
    private function validate() {//para mostra erro de validacao na tela
        $errors = [];

        if(!$this->name) { //comando para aparecer vermelho campo obrigatorio
            $errors['name'] = 'Nome é um campo abrigatório.';
        }
    
        if(!$this->email) { //comando para aparecer vermelho campo obrigatorio
            $errors['email'] = 'Email é um campo abrigatório.';
        } elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email inválido.';
        }
  
        if(!$this->start_date) {//comando para digitar  a data correta
            $errors['start_date'] = 'Data de Admissão é um campo abrigatório.';
        } elseif(!DateTime::createFromFormat('Y-m-d', $this->start_date)) {
            $errors['start_date'] = 'Data de Admissão deve seguir o padrão dd/mm/aaaa.';
        }
 
        if($this->end_date && !DateTime::createFromFormat('Y-m-d', $this->end_date)) {
            $errors['end_date'] = 'Data de Desligamento deve seguir o padrão dd/mm/aaaa.';
        }
    
        if(!$this->password) {//comando para aparecer vermelho campo obrigatorio
            $errors['password'] = 'Senha é um campo abrigatório.';
        }
     
        if(!$this->confirm_password) {//comando para aparecer vermelho campo obrigatorio
            $errors['confirm_password'] = 'Confirmação de Senha é um campo abrigatório.';
        }
           //esta parte para duas senha tem q ser as duas correta
        if($this->password && $this->confirm_password //se estes foram defirente erro de senha
            && $this->password !== $this->confirm_password) {
            $errors['password'] = 'As senhas não são iguais.';
            $errors['confirm_password'] = 'As senhas não são iguais.';
        }
    
        if(count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

}
      
 