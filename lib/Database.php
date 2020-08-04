<?php

/* This class sets up and closes database connections for use within all of the 
other classes within the system. Depends on the configuration file being set up
with the details for detable connectivity.*/
class Database {
    
    public $connection;
    
    public function __construct($configFile)
    {
        //Establish a connection to the database file
        $this->connection = new mysqli($configFile['dbHost'], $configFile['dbUser'], 
                $configFile['dbPassword'], $configFile['dbTable']);
		
		//DEBUG: If failed to connect, create an error message
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
    }
    
	//Close the mysqli connection when the object is done
    public function __destruct() 
    {
        mysqli_close($this->connection);
    }
    
}
