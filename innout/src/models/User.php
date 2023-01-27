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
    }