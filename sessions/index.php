<?php 
class  Sessao{
    private static $db_conexao;
    private static $content=[];
    private static $session_id;
    
    public static function init($db_conexao){
        self::$db_conexao = $db_conexao;
    }

    public static function hasCookie(){
        if(isset($_COOKIE['su_session_id'])){
            return true;
        }
        return false;
    }

    public static function setSessionId($session_id){
        self::$session_id = $session_id;
    }

    public static function hasSession(){

        if(!self::hasCookie()){
            return false;
        }

        $session_id = $_COOKIE['su_session_id'];

       $res = mysqli_query(self::$db_conexao,
         'select count(*) from sessions where session_id ="'.
         $session_id.'"');

        $data = mysqli_fetch_row($res);

        if($data[0] > 0){
            self::setSessionId($session_id);
            return true;
        }

        return false;
    }

    public static function start(){
        $res = mysqli_query(self::$db_conexao, 
        'select content from sessions where session_id="'.
        self::$session_id.'"');

        $data = mysqli_fetch_row($res);

        if($data[0] == ''){
            self::$content = json_decode('[]');
        }
        else{
            self::$content = json_decode($data[0]);
        }
    }



    public static function create_session(){
        $session_id = self::generateSessionId();
        mysqli_query(self::$db_conexao, 
        'insert into sessions (session_id, content) values ("'. 
        $session_id.'", "[]")');
        //setcookie('su_session_id', $session_id, time()+(2592000 * 12));
        setcookie('su_session_id', $session_id, time()+300, '/');
        return $session_id;
    }
    private static function generateSessionId(){
        $bytes = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.
        '1234567890-_.$!';
        $res = '';
        for($x = 0; $x < 16; $x++){
           $random =  rand(0, strlen($bytes)-1);
           $res .= $bytes[$random];
        }
        return $res;
        
    }

    public static function putContent($path, $value){
        $paths = explode('.', $path);

        $current_object = &self::$content;

        for($x = 0; $x < count($paths); $x++){
            if($x == count($paths)-1){
                $current_object[$paths[$x]] = $value;
            }
            else{
                
                if(array_key_exists($paths[$x], $current_object)){
                    $current_object = &$current_object[$paths[$x]];
                }
                else{
                    $current_object[$paths[$x]] = array();
                    $current_object = &$current_object[$paths[$x]];
                }
            }
        }
    }

    public static function getContent($path){
        $paths = explode('.', $path);

        $current_object = self::$content;

        for($x = 0; $x < count($paths); $x++){
            if($x == count($paths)-1){
                return $current_object[$paths[$x]];
            }
            else{
                
                if(array_key_exists($paths[$x], $current_object)){
                    $current_object = $current_object[$paths[$x]];
                }
                else{
                    return '';
                }
            }
        }
    }

    public static function commitContent(){

        mysqli_query(self::$db_conexao, 'update sessions set content="'.
        mysqli_real_escape_string(self::$db_conexao, json_encode(self::$content)).'" where session_id="'.self::$session_id.'"');
    }
}
?>