<?php 

require_once __DIR__.'/../autoload.php';

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == 'adm' && $password == '123'){
        $conexao = Db::connect();
        Sessao::init($conexao);

        if(!Sessao::hasSession()){
            Sessao::create_session();
        }
    }
}

header('Location: /');