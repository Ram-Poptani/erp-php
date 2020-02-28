<?php
class DependencyInjector{
    private $dependencies = [];

    public function set(string $key, $value)
    {
        $this->dependencies[$key] = $value;//set the dependencies in array like 'database' => $database
    }

    public function get(string $key)
    {
        if(isset($this->dependencies[$key])){
            return $this->dependencies[$key]; //get the dependencies from array only by passing the name like get('database')
        }
        die('This dependency not found :'. $key);
    }
}