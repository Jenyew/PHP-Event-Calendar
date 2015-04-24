<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class DB {

    public  $error = false,  //bool - error state of last action
            $errorMessage = null, //sting - error message
            $resultsArray = array(), // array - action results
            $count = 0, // int - count of rows affected/results
            $lastInsertId = null, // int - last insert id
            $errorLogId = null; // int - error log id
            
      
    private $_pdo = null, // PDO object
            $_query = null, // string - last prepared query
            $_error = false, //bool - error state of last action
            $_errorInfo = null, //sting - error message
            $_results = null, // array - action results
            $_count = 0, // int - count of rows affected/results
            $_sql = ''; // string - last sql string

 
    public function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host='._HOST_NAME_.';dbname='._DATABASE_NAME_,
    						_USER_NAME_,_DB_PASSWORD_,NULL);
        } catch(PDOException $e) {
        	$this->errorMessage = $e->getMessage();
            $this->error = true;
            throw $e;
        } 
    }
 
   public function query($sql, $params = array(),$handleErrors=false) {

		$this->_error = false;
		$this->_errorInfo = NULL;
		$this->_results = NULL;
		$this->_count = "0";
		$this->_sql = $sql;
                $this->lastInsertId = null;

		if($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if(count($params)) {
				foreach($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			if($this->_query->execute()) {
				$this->lastInsertId = $this->_pdo->lastInsertId();
				$this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
				$this->_count = $this->_query->rowCount();
                                
			} else {
				$this->_error = true;
				$this->_errorInfo = $this->_query->errorInfo();
				$this->errorMessage = $this->_returnErrorMessage();
				
			}
		}
                
		return $this->_results;
	}

    /**
     * 
     * @param string $sql a sql query prepre-ready ex :name 
     * @param array $params the parameters array(':name'=>value)
     * @return \DBPDO [sets: resultsArray, _count, count, error, _errorInfo, lastInsertId, errorMessage]
     */
    public function queryAssoc($sql, $params = array()) {
        // Lets set some defaults.
	        $this->error = false;
	        $this->errorMessage = null;
	        $this->_errorInfo = null;
	        $this->_resultsArray = array();
            $this->errorLogId = null;
            $this->count = 0;
 		//This next line of code will not ever throw a error, It'll always return a PDOStatement object (because emulation is turned on)
 		$this->_query = $this->_pdo->prepare($sql);
 		// Next we want to attempt to execute the pdoStatement Object
            if($this->_query->execute($params)) {
 		// This statement executed successfully.
 	    	$this->resultsArray = $this->_query->fetchAll(PDO::FETCH_ASSOC);
                $this->_count = $this->_query->rowCount();
                $this->count = $this->_query->rowCount();
            } else {
            	// This prepreared statement query failed for some reason.
            	$this->error = true;
            	$this->_errorInfo = $this->_query->errorInfo();
                $this->lastInsertId = $this->_pdo->lastInsertId();
                
            	$this->errorMessage = $this->_returnErrorMessage();
            	$this->resultsArray = array();
            	$this->_count = 0;
            	$this->count = 0;
            }
        // Last lets return the whole object
        return $this;
    }
    
    /**
     * This function was built for use only with inser/update/delete statements.
     * @param string $sql a sql query prepre-ready ex :name 
     * @param array $params the parameters array(':name'=>value)
     * @return \DBPDO
     */
    public function sqlSave($sql,$params=array()){
        // Lets set some defaults.
	    $this->error = false;
	    $this->errorMessage = null;
            $this->lastInsertId = null;
	    $this->_errorInfo = null;
	    $this->_resultsArray = array();
 	//This next line of code will not ever throw a error, It'll always return a PDOStatement object (because emulation is turned on)
            $this->_query = $this->_pdo->prepare($sql);
 	// Next we want to attempt to execute the pdoStatement Object
            if($this->_query->execute($params)) {
                $this->_count = $this->_query->rowCount();
                $this->count = $this->_query->rowCount();
                $this->lastInsertId = $this->_pdo->lastInsertId();
            } else {
            	// This prepreared statement query failed for some reason.
            	$this->error = true;
            	$this->_errorInfo = $this->_query->errorInfo();
                $this->lastInsertId = $this->_pdo->lastInsertId();
            	$this->errorMessage = $this->_returnErrorMessage();
            	$this->resultsArray = array();
            	$this->_count = 0;
                $this->count = 0;
            }
        return $this;
    }    

    private function _returnErrorMessage(){
        if($this->_errorInfo[2] != ""){
            return $this->_errorInfo[2];
        } else if ($this->_errorInfo[1] != "") {
            return "Driver Specific Error - " . $this->_errorInfo[1];
        } else if ($this->_errorInfo[0] == 'HY093'){
            return "Sql state Error[HY092] Sql prepare, invalid parameter number or parameter was not defined.";
        } else if ($this->_errorInfo[0] != ""){
            return "Unknown driver specific error code " . $this->_errorInfo[0]; 
        } else {
            return "Unknown SQL error";
        }
    }

    public function results() {
        // Return result object
        return $this->_results;
    }

    public function first() {
        return $this->_results[0];
    }

    public function count() {
        // Return count
        return $this->_count;
    }

    public function error() {
        return $this->_error;
    }
    public function errorMessage() {
		if($this->_error) {
			return $this->errorMessage;
		}
		return false;
	}
	public function sql() {
		return $this->_sql;
	}
	public function quote($str) {
		return $this->_pdo->quote($str);
	}
	public function lastInsertID() {
		return $this->_lastInsert;
	}
	
}

?>
