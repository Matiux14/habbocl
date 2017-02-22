<?php
class Database{
 
    private $username = "root";
	private $port = 3306;
    private $password = "";
    private $hostname = "";
    private $database = "";
    private $dbConnection = null;
    private $parametres = array();
	public $querys = 0;
    public $querysUsed = array();
    public function __construct($host, $port, $username, $password, $dbName){
        $this->username = $username;
		$this->port = $port;
        $this->password = $password;
        $this->hostname = $host;
        $this->database = $dbName;
    }
    
    private function NeedInit(){
        if($this->dbConnection == null){
            $this->dbConnection = new mysqli($this->hostname, $this->username, $this->password, $this->database, $this->port) or die('error');
			if($this->dbConnection->connect_errno){
			}
		}
    }
	
	public function error(){
		return $this->dbConnection->error;
	}
    public function clear(){
        unset($this->parametres);
        $this->parametres = array();
    }  
    
    public function kill(){
        if($this->dbConnection !== null){
            $this->dbConnection->close();
            $this->dbConnection = null;
        }
    }
	
    public function AddParametresWithValue($id, $value){
        $this->parametres[$id] = $value;
    }

    public function query($query, $forzeClear = false){
        $this->NeedInit();
		$this->querysUsed[] = $query;
        $tmp = array();
        foreach($this->parametres as $id => $value){
            $tmp['@' . $id] = "'" . @$this->dbConnection->escape_string($value) . "'";
        }
        foreach($tmp as $search => $put){
            $query = str_replace($search, $put, $query);
        }
		$this->querys++;
        unset($tmp);
        
        if($forzeClear){
            $this->clear();
        }
        return $this->dbConnection->query($query);
    }
	public function insert_id(){
		return $this->dbConnection->insert_id;
	}
    public function escape_string($word){
		$this->NeedInit();
		$word = $this->dbConnection->escape_string($word);
		return $word;
	}
    public function insertInto($table, $p = array(), $exec = true){
        $this->NeedInit();
         
        $query = "INSERT INTO " . $table;
        $part1 = '';
        $part2 = '';

        foreach($p as $id => $value){
            $part1 .= "`" . $id . "`, ";
            $part2 .= "'" . $this->dbConnection->escape_string($value) . "', ";
        }

        $part1 = substr($part1, 0, strlen($part1) - 2);
        $part2 = substr($part2, 0, strlen($part2) - 2);
        
        $query .= " (" . $part1 . ") VALUES (" . $part2 . ");";
        
        if($exec){
            return $this->query($query);
        }else{
            return $query;
        }
    }
	
	function result($query, $field = 0){
		if(is_object($query)){
			$rQuery = $query->fetch_array();
		}
		else{
			$query = $this->query($query) or die($this->dbConnection->error);
			$rQuery = $query->fetch_array();
		}
		return $rQuery[$field];
	}
	
	function num_rows($query){
		if(is_object($query)){
			$r = $query->num_rows;
		}else{
			$query = $this->query($query) or die($this->dbConnection->error);
			$r = $query->num_rows;
		}
		return $r;
	}
}
?>
