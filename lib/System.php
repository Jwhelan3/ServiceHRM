<?php

/* This class sets up the system, bringing together the core components
and allowing database functionality across all derived classes. */
class System {
    protected $db;         //Store the database wrapper in a higher scope
    protected $Audit;	   //Store the audit class in higher scope for logging user actions
    
    public function __construct()
    {
        //Fetch the configuration
        $configFile = require_once('inc/config.php');
        
        //Fetch the other class files
        require_once('lib/Database.php');
	require_once('lib/Audit.php');
        
        //Instantiate required classes
        $this->db = new Database($configFile);
	$this->Audit = new Audit($this->db->connection);
    }
}
