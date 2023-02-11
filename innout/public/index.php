<?php


require_once(dirname(__FILE__, 2) . '/src/config/config.php');//boot da aplicacao

//require_once(realpath(CONTROLLER_PATH . '/login.php'));//direcionou a pasta login.php do controler


$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));//logica para passar pelo index server laragon sobre a barra do brower


if(($uri === '/' || $uri ===  ' ' || $uri === '/index.php')){
      $uri = '/day_records.php' ; // carrega pasta day_records esta dentro da pasta template

}


require_once(CONTROLLER_PATH . "{$uri}");



//require_once(realpath(CONTROLLER_PATH . '/day_records.php'));








