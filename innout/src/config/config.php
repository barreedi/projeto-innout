<?php
date_default_timezone_set('America/Sao_Paulo');//aqui para o horario fuso horario//
setlocale(LC_TIME,'pt_BR','pt_BR,uft-8','portuguese');//aqui para o idioma//

//constantes gerais
define('DAILY_TIME', 60 * 60 * 8) ;//daily time como 8 horas d trabalho PARA HORAS TRABALHADAS NO DATA_GENERATOR.PHP//


//pastas
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));//definindo a pasta q vai ser models
define('VIEW_PATH', realpath(dirname(__FILE__) . '/../views'));
define('TEMPLATE_PATH', realpath(dirname(__FILE__) . '/../views/template'));//para direcionar a pasta views/template/messages
define('CONTROLLER_PATH', realpath(dirname(__FILE__) . '/../controllers'));//vai chamar login.php na pasta controler
define('EXCEPTION_PATH', realpath(dirname(__FILE__) . '/../exceptions'));



//Arquivos banco de dados//
require_once(realpath(dirname(__FILE__) . '/database.php'));
require_once(realpath(dirname(__FILE__) . '/loader.php'));//para carregar as class//
require_once(realpath(dirname(__FILE__) . '/session.php'));
require_once(realpath(dirname(__FILE__) . '/date_utils.php'));
require_once(realpath(dirname(__FILE__) . '/utils.php'));//para metodos utilitarios no marcar ponto
require_once(realpath(MODEL_PATH . '/Model.php'));
require_once(realpath(MODEL_PATH . '/User.php'));
require_once(realpath(MODEL_PATH . '/WorkingHours.php'));
require_once(realpath(EXCEPTION_PATH . '/AppException.php'));
require_once(realpath(EXCEPTION_PATH . '/ValidationException.php'));//parte do codigo errors especificos sobre email e senha errada
