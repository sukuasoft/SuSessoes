<?php 
    require_once __DIR__.'/autoload.php';

    $conexao = Db::connect();
    Sessao::init($conexao);

    $isLogado  = false;
    if(Sessao::hasSession()){
        Sessao::start();
        $isLogado=true;
    }
?>

<?php 
    if($isLogado){

?>
    <strong>Você está logado</strong>
<?php 

    }
    else{
?>
    <form action="actions/login.php" method="POST">
        <h2>Login</h2>
        <input name="username" type="text" placeholder="Nome de usuario"> <br>
        <input name="password" type="text" placeholder="Senha"> <br><br>
        <button type="submit">Entrar</button>
    </form>
    <style>
        form{
            font-family: sans-serif;
            width: 350px;
            margin:0px auto;
            background:#eee;
            padding: 10px 20px;
            text-align: center;
        }

        input, button{
            border:none;
            outline: none;
           
        }
        input{
            padding: 6px 18px;
            display: block;
            width: fit-content;
            margin: 0px auto;
            background: #ccc;
        }
        button{
            display: block;
            width: fit-content;
            margin: 0px auto;
            background-color: dodgerblue;
            color:white;
            padding: 6px 12px;
        }
    </style>
<?php 

        
    }
?>