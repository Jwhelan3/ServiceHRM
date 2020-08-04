<?php

/*Manages the system adding database functionality for non-secure pages*/
class Manager {
    public $pageName;   //Store the page name for initialising the view later
    public $db;         //Store the database wrapper in a higher scope
    
    public function __construct($currentPage)
    {
        $this->pageName = $currentPage; //Take the page name from the calling code and store it in the class
        
        
        //Fetch the configuration
        $configFile = require_once('inc/config.php');
        
        //Fetch the other class files
        require_once('Database.php');
        
        //Create a connection to the database with the Database Wrapper class
        $this->db = new Database($configFile);
        
    }
}
