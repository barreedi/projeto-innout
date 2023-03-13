<?php
session_start();//para chamar a tela de login
session_destroy();//vai limpar a tela do usuario e volta tela de login
header('Location: login.php');