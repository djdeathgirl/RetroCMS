<?php
//////////////////////////////////////////////////////////////
// 					RetroCMS 								//
//<<<<<<<<<<<<<< The Oldschool Era is Back >>>>>>>>>>>>>>>>>//
//----------------------------------------------------------//
// Developed by: Marcos ( M.tiago )							//
//////////////////////////////////////////////////////////////
// Alpha Version 0.8.1 ( Citrine ) 							//
// Branch: Public (Unstable)								//
//////////////////////////////////////////////////////////////

class Model{
	protected $hotelConection;


	public function getAll($Table){	
			try {
			$sql = 'SELECT * FROM .'.$Table.' order by id';
			$stmt = $this->hotelConection->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			}catch(Exception $e){
			//If not return false
			return false;
			exit;
		}
		return $result;		
	}
	
	public function getById($Column,$Id){
	
	}

	public function getByColumn($Table,$Column,$Param){
		try {
			$sql = 'SELECT * FROM .'.$Table.' where order by id';
			$stmt = $this->hotelConection->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			}catch(Exception $e){
			//If not return false
			return false;
			exit;
		}
		return $result;	
	}
	
	public function deleteById($Column,$Id){
		
	}
	
	
}



?>
