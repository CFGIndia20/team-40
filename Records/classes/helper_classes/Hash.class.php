<?php

class Hash{
    public function make($plainText){
        return password_hash($plainText, PASSWORD_BCRYPT, ['cost'=>10]);
    }

    public function verify($plain, $hash){
        return password_verify($plain, $hash);
    }

    public function generateRandomToken($id){
        return hash("sha256", $id.TokenHandler::getCurrentTimeInMilliSec().strrev($id).rand());
    }
}

?>