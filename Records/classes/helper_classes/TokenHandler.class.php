<?php

class TokenHandler{
    private static $REMEMBER_EXPIRY_TIME = "30 minutes";
    private static $FORGOT_PWD_EXPIRY_TIME = "15 minutes";

    private $table = 'tokens';

    private static $CREATE_QUERY = "CREATE TABLE IF NOT EXISTS tokens (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, token VARCHAR(255) UNIQUE, expires_at DATETIME NOT NULL, is_remember TINYINT DEFAULT 0)";

    private $database;
    private $hash;

    public function __construct(DependencyInjector $di){
        $this->database = $di->get("database");
        $this->hash = $di->get("hash");
    }

    public static function getCurrentTimeInMilliSec(){
        return round(microtime(true) * 1000);
    }

    public function build(){
        $this->database->query(TokenHandler::$CREATE_QUERY);
    }

    public function getValidExistingToken(int $user_id, int $isRemember){
        $query = "SELECT * FROM {$this->table} WHERE user_id = {$user_id} AND expires_at >= NOW() AND is_remember = {$isRemember}";
        $retVal = $this->database->rawQueryExecutor($query);

        return $retVal[0]['token'] ?? null;
    }

    public function createRememberMeToken(int $user_id){
        return $this->createToken($user_id, 1);
    }

    public function createForgotPasswordToken(int $user_id){
        return $this->createToken($user_id, 0);
    }

    private function createToken(int $user_id, int $isRemember){
        $validToken = $this->getValidExistingToken($user_id, $isRemember);

        if($validToken){
            return $validToken;
        }

        $current = date("Y-m-d H:i:s");
        $timeToBeAdded = $isRemember ? TokenHandler::$REMEMBER_EXPIRY_TIME : TokenHandler::$FORGOT_PWD_EXPIRY_TIME;

        $data = [
            'user_id' => $user_id,
            'token' => $this->hash->generateRandomToken($user_id),
            'expires_at' => date('Y-m-d H:i:s', strtotime($current. "+" . $timeToBeAdded)),
            'is_remember' => $isRemember
        ];

        return $this->database->table($this->table)->insert($data) ? $data['token'] : null;
    }

    public function isValid(string $token, int $isRemember){
        $current = date('Y-m-d H:i:s');
        return !empty($this->database->rawQueryExecutor("SELECT * FROM {$this->table} WHERE token = '$token' AND expires_at >= NOW() AND is_remember = $isRemember"));
    }

    public function getUserFromValidToken($token){
        return $this->database->table($this->table)->where('token', '=', $token)->first();
    }

    public function deleteToken($token){
        $sql = "DELETE FROM {$this->table} WHERE token = '{$token}'";
        return $this->database->query($sql);
    }
}

?>