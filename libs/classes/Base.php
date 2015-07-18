<?php
namespace Libs\MyClass;
/**
 * Description of Base class
 *
 * @author Alek
 */
class Base {
	protected $_error = null;
	protected $db;
	
	protected $_primary_key = "id";
	protected $_relate_tb = "tb";
	protected $_lastInsertID = -1;
	
    public function __construct($relate_tb = "tb",$primary_key = "id") {
    	//define database connection
    	$this->db = ADONewConnection(DB_TYPE);
		$this->db->Connect(DB_HOST, DB_USER, DB_PASS,DB_NAME);
		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
		//$this->db->debug=true;
		$charset[] = "SET character_set_client='utf8'";
		$charset[] = "SET character_set_results='utf8'";
		$charset[] = "SET character_set_connection='utf8'";
		for($i=0;$i<=2;$i++) {
	            $this->db->Execute($charset[$i]);
		}
		
		$this->error = "";
		
		$this->primary_key = $primary_key;
		$this->relate_tb = $relate_tb;
    }
	public function save($data){
		$sql = "select * from {$this->relate_tb} where {$this->primary_key} = -1";
	    $rs = $this->db->Execute($sql);
	   
	    $data['updatedtime'] = $data['createdtime'] = time();
	    $insertSQL = $this->db->GetInsertSQL($rs, $data);
		
	    $this->db->Execute($insertSQL);
	    $this->lastInsertID = $this->db->Insert_ID();
		return $this->lastInsertID;
	}
	public function update($data){
		$sql = "select * from {$this->relate_tb} where {$this->primary_key} = {$data[$this->primary_key]}";
		
	    $rs = $this->db->Execute($sql);
	    
		print_r($data);
	    $data['updatedtime'] = time();
		$updateSQL = $this->db->GetUpdateSQL($rs, $data);
		
		return $this->db->Execute($updateSQL);
	}
	public function delete($id){
        $sql = "DELETE FROM {$this->relate_tb} WHERE {$this->primary_key} = {$id}";
        $this->db->Execute($sql);
        return true;
    }
    public function get_all($fields){
		$fields_str = implode(",", $fields);
		$sql = <<<EOD
		select {$this->primary_key} as id,{$fields_str} from {$this->relate_tb}
EOD;
		$rs = $this->db->GetAll($sql);
		return $rs;
	}
    
	//SET & GET FUNCTION
	public function get_error(){
        return $this->_error;
    }
    public function set_error($error){
        $this->_error = $error;
    }
	public function get_primary_key(){
		return $this->_primary_key;
	}
	public function set_primary_key($primary_key){
		$this->_primary_key = $primary_key;
	}
	public function get_relate_tb(){
		return $this->_relate_tb;
	}
	public function set_relate_tb($relate_tb){
		$this->_relate_tb = $relate_tb;
	}
	public function get_lastInsertID(){
		return $this->_lastInsertID;
	}
	public function set_lastInsertID($lastInsertID){
		$this->_lastInsertID = $lastInsertID;
	}
    public function __destruct() {
        $this->db->Disconnect();
    }
}