<?php

class Database {
    public static function getConnection(){//funcao para conexao getconnection//
        //$envpath é o caminho pegando o diretorio q é a pasta//
        $envPath = realpath(dirname(__FILE__) . '/../env.ini');//..env.ini para sair da pasta config para nao ir para o githost//
        $env = parse_ini_file($envPath);// $env caminho para acessar as pasta index,env,database//
        $conn = new mysqli($env['host'],$env['username'],$env['password'],$env['database']);//pegando os comando para acessar o banco//
        $conn->set_charset("utf8mb4");
        if($conn->connect_error){
            die("Error:" . $conn->connect_error);
        }
        return $conn;
    }
    public static function getResultFromQuery($sql){//criando uma funcao static a partir da consulta //
      $conn = self::getConnection();//se usa self referente a class//
      $result = $conn->query($sql);
      $conn->close();
      return $result;
    }

    //esta parte conexao com banco sobre as horas trabalhadas working_hours
       public static function executeSQL($sql){//criando uma funcao static execute //
        $conn = self::getConnection();//se usa self referente a class esta pegando ja do ine//
      if(!mysqli_query($conn,$sql)){//se nao for conexao entao é erro
          throw new Exception(mysqli_error($conn));
       }

      $id = $conn->insert_id;//id vai ser a conexao que aponta para insert id na tabela
       $conn->close();//depois fecha a conexao 
       return $id;//retorna o id que esta no banco
        
   }
}
