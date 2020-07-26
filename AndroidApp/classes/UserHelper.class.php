<?php
class UserHelper{
    private $database;
    private $table = "users";
    public function __construct(Database $database){
        $this->database = $database;
    }

    public function getUserByEmail(string $email){
        return $this->database->table($this->table)->where('email', '=', $email)->first();
    }


}

?>