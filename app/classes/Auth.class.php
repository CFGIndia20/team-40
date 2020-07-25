<?php
class Auth{
    protected $database;
    protected $hash;
    protected $table = "admin";
    protected $authSession = 'user';
    public function __construct(Database $database, Hash $hash){
        $this->database = $database;
        $this->hash = $hash;
    }

    public function build(){
    return $this->database->query("CREATE TABLE IF NOT EXISTS {$this->table} (id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, email VARCHAR(255) NOT NULL UNIQUE, name VARCHAR(20) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL)");
    }

    public function create($data){
        // die(var_dump($data));
        if(isset($data['password'])){
            $data['password'] = $this->hash->make($data['password']);
        }
        
        return $this->database->table($this->table)->insert($data);
    }

    public function signIn($data){
        $user = $this->database->table($this->table)->where('email', '=', $data['email']);
        if($user->count() == 1){
            $user = $user->first();
            // die(var_dump($data));
            // die(var_dump($user));
            if($this->hash->verify($data['password'], $user->password)){
                // echo "In";
                $this->setAuthSession($user->id);
                return true;
            }
        }
        return false;
    }

    public function setAuthSession($id){
        $_SESSION[$this->authSession] = $id;
    }

    public function check(){
        
        return isset($_SESSION[$this->authSession]);
    }
    public function signout(){
        setcookie('token', '', time()-5000);
        $user_id = $_SESSION[$this->authSession];
        $sql = "DELETE FROM tokens WHERE user_id = {$user_id} and is_remember=1";
        $this->database->query($sql);
        //die($user_id);
        unset($_SESSION[$this->authSession]);
    }    

    public function resetUserPassword(string $token, string $password){
        $password = $this->hash->make($password);
        return $this->database->query("UPDATE admin, tokens SET admin.password ='$password' WHERE admin.id = tokens.user_id and tokens.token = '$token'");
    }

    public function user(){ //returns object of name of user unlike check() jo sirf ye batata hai ki user is logged in or not
        if(!$this->check()){
            return false;
        }
        $user = $this->database->table($this->table)->where('id', '=', $_SESSION[$this->authSession])->first();
        return $user;
    }
}

?>