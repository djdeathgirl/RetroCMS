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

class HabboModel extends Model{

	public function __construct($hotelConection){
		$this->hotelConection = $hotelConection;
	}
	
	//Test if data of habboObject as like on Database
	/*
	 + This Function will return 3 values [ STATUS OF FUNCTION , ERROR CODE , EXTRA INFORMATION ]
	 + If Habbo Data as correctly and he/she not banned so return [ true, null , null ]
	 + If Habbo not exist "1" or password not match "2", returns [ false, CODE , null ]
	 + If Habbo as banned temporarly "3", returns [ false,3 , "String of ban expiration time" ]	 
	 + If Habbo as banned permanently "4", returns [ false,4 , "Reason" ];	 
	*/
	
	public function get_HabboObject($habboId){
		$habboObject = new Habbo();
		//Get one row from table (users) where id as equal habboId value;
		$row = $this->getById('users',$habboId);
		$habboObject->constructObject($row['id'],$row['username'],$row['password'],$row['rank'],$row['figure'],$row['sex'],$row['credits']);
		return $habboObject;
	}
	
	public function set_HabboLogin($testObject){
		//New Habbo
		$habboObject = new Habbo();
		
		//Get all content from table (users) where Column(username) as equal habboObject username
		$result = $this->getByParam('users','username',$testObject->get_HabboName());
		
		//If found the habbo
		if(count($result) == 1){
			$row = $result[0];
			$habboObject->constructObject($row['id'],$row['username'],$row['password'],$row['rank'],$row['figure'],$row['sex'],$row['credits']);
			
			//Check if password match
			if(sodium_crypto_pwhash_str_verify($habboObject->get_HabboPassword(), $testObject->get_HabboPassword())){
				
				//Check if not banned
				if($habboObject->get_HabboRank() < 0){
					//Returns (Habbo Banned)
					return array(false,4,"Some Reason");
					exit;		
				}
				
			}else{
				//Returns (Password wrong)
				return array(false,2,0);
				exit;	
			}
			
		}else{
			//Returns (Habbo not exist)
			return array(false,1,0);
			exit;
		}
		$habboObject->set_HabboSession();
		return array(true,0,0);
	}
	
	
	//Return a valid Habbo Ticket
	public function get_ValidTicket($habboObject){
		$uniqueTicket = true;
		$result = $this->getColumn('users','sso_ticket');
		if (count($result) > 0){
			$uniqueTicket = true;
			do{
				$ramdomTicket = 'LT-'.rand (100000 , 999999 ).'-'.bin2hex(random_bytes(10)).'-'.$habboObject->get_HabboLanguage().'-fe2';
				foreach($result as $existingTicket){
					if($ramdomTicket == $existingTicket){
						$uniqueTicket = false;
					}
				}
			}while($uniqueTicket == false);
		}	
		return $ramdomTicket;
	}
	
	public function set_HabboTicket($habboObject){
		return $this->setColumnById('users', 'sso_ticket', $habboObject->get_HabboId(), $habboObject->get_HabboTicket());
	}
	
}

?>