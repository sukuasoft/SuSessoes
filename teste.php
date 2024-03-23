<?php 
require_once __DIR__.'/autoload.php';
$conexao = Db::connect();
Sessao::init($conexao);

$session_id = Sessao::create_session();
Sessao::setSessionId($session_id);

Sessao::putContent('user_id', 1);
Sessao::putContent('expires', 100);
Sessao::putContent('datas.inicio', 2023);
Sessao::putContent('datas.fim', 2026);

Sessao::commitContent();

?>