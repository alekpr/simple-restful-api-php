<?php
namespace Libs\MyClass;
class Coffee extends Base {
	private $fields = array("title","description");
	private $key = "coffee_k";
	
	public function __construct(){
		parent::__construct(TB_COFFEE,$this->key);
	}
	/**
	 * Funciton AllCoffee
	 * Description - Get all coffee
	 * @return array $coffees - list of coffee data
	 */
	public function AllCoffee(){
		$coffees = $this->get_all($this->fields);
		return $coffees;
	}
	/**
	 * Function get_ById
	 * Description - Get coffee by id
	 * @param int $id - coffee id
	 * @return array $data - coffee data
	 */
	public function get_byId($id){
		$fields_str = implode(",", $this->fields);
		$sql = <<<EOD
		select {$this->primary_key} as id,{$fields_str} from {$this->relate_tb} where {$this->primary_key} = {$id}
EOD;
		$data = $this->db->GetRow($sql);
		return $data;
	}
	/**
	 * Function UpdateCoffe
	 * Description - Update coffee data
	 * @param 	int $id - coffee id
	 * 			array $data - coffee data
	 * @return 	boolean true/false
	 */
	public function UpdateCoffee($id,$data){
		$data[$this->primary_key] = $id;
		return $this->update($data);
	}
	public function __destruct() {
		parent::__destruct();
	}
}
