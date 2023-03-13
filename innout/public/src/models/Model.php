<?php

class Model
{
    protected static $tableName = '';
    protected static $columns = [];
    protected $values = [];//criando um atributo array pertence para cada instancia criada values array vazio

    function __construct($arr, $sanitize = true)//sanitize para tirar todos os caracteres q nao faz sentido como nome por exemplo
    {
      $this->loadFromArray($arr, $sanitize);
    }

    public function loadFromArray($arr, $sanitize = true)//comando para limpar digitacao de string
    {

        if ($arr) { 
            $conn = Database::getConnection();//para pegar a conectacao
            foreach ($arr as $key => $value) {//correndo o valores 
                $cleanValue = $value;//cleanvalue igual value
                if ($sanitize && isset($cleanValue)) {//se santitive e cleanvalue faça
                    $cleanValue = strip_tags(trim($cleanValue));//para tirar todos os espacos em branco
                    $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);//vai pegar for digitado diferente converte em html
                     $cleanValue = mysqli_real_escape_string($conn, $cleanValue); //vai garantir q nao vai ter mysqli ingeti 
                }
                $this->$key = $cleanValue;//a chave igual a cleanvalue
            }
             $conn->close();
        }
    }
    
    public function __get($key) //estas barras sao metodo magico
    {
        return isset($this->values[$key]) ? $this->values[$key] : null;
    }

    public function __set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function getValues()
     {
        return $this->values;
    }        
                                     //valor padrao '*'//
    public static function getOne($filters = [], $columns = '*') //criando uma funcao para filtrar os usuario
    {  //Esta parte para criar implementar com getOn acesso login e senha//
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $columns);
        return $result ? new $class($result->fetch_assoc(), false) : null;
    }
       
    public static function get($filters = [], $columns = '*') 
    {
        $objects = [];
        $result = static::getResultSetFromSelect($filters, $columns);//retorna os objetos nao as linhas
        if ($result) {
            $class = get_called_class();
            while ($row = $result->fetch_assoc()) {
                array_push($objects, new $class($row, false));
            }
        }
        return $objects;
    }

    public static function getResultSetFromSelect($filters = [], $columns = '*')
    {
        $sql = "SELECT {$columns} FROM "
            . static::$tableName
            . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql);
        if ($result->num_rows === 0) {
            return null;
        } else {
            return $result;
        }
    }

    public function insert()//metodo insert para com o banco sobre horas trabalhadas working hours//
    {//vai inserir no banco estes dados horas trabanhadas
        $sql = "INSERT INTO " . static::$tableName . " ("
             . implode(",", static::$columns) . ") VALUES (";//implode pega o array transforma numa string vai ser columns
        foreach (static::$columns as $col) {
            $sql .= static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) - 1] = ')';// - 1 para pegar a ultima string do array q vai ser igual a = ')'//
        $id = Database::executeSQL($sql);//metodo static do database funcao executesql//
        $this->id = $id;//atributo id//
    }

    public function update() 
    {
        $sql = "UPDATE " . static::$tableName . " SET ";
        foreach (static::$columns as $col) {//percorrendo as colunas
            $sql .= " {$col} = " . static::getFormatedValue($this->$col) . ",";//percorrendo colunas pasta workinghours
        }
        $sql[strlen($sql) - 1] = ' ';
        $sql .= "WHERE id = {$this->id}";
        Database::executeSQL($sql);
    }

    public static function getCount($filters = []) //funcao para o contador relatorio gerencial
    {
        $result = static::getResultSetFromSelect(//vai pegar o relatorio das horas trabalhada
            $filters, 'count(*) as count'
        );
        return $result->fetch_assoc()['count'];//pega as contagem banco de dados
    }

    public function delete() 
    {
        static::deleteById($this->id);
    }
    public static function deleteById($id) //excluindo pelo id do usuario da tela usuario novo usuario
    {
        $sql = "DELETE FROM " . static::$tableName . " WHERE id = {$id}";
        Database::executeSQL($sql);
    }

    private static function getFilters($filters) 
    {
        $sql = '';
        if (count($filters) > 0) {
            $sql .= " WHERE 1 = 1";
            foreach ($filters as $column => $value) {
                if ($column == 'raw') {
                    $sql .= " AND {$value}";//aqui para sql puro
                } else {
                    $sql .= " AND {$column} = " . static::getFormatedValue($value);
                }
            }
        } 
        return $sql;
    }
    
    private static function getFormatedValue($value) 
    {
        if (is_null($value)) {
            return "null";
        } elseif (gettype($value) === 'string') {
            return "'{$value}'";
        } else {
            return $value;
        }
    }
}

