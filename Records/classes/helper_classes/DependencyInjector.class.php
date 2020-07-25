<?php

/**
 * The below class will be used to inject dependencies.
 * It has a key value pair, where the object names and actual objects are stored
 * You can just use the get and set method to use these objects to inject dependencies
 * 
 * 
 * In short, ye ek HashMap hai objects ka...just to obtain them, just like chat system ka sockets
 */

class DependencyInjector
{
    private $dependencies = [];

    public function set(string $key, $value)
    {
        $this->dependencies[$key] = $value;
    }

    public function get(string $key)
    {
        if(isset($this->dependencies[$key]))
        {
            return $this->dependencies[$key];
        }
        die("This dependency Not Found: ". $key);
    }
}

?>