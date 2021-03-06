<?php
//////////////////////////////////////////////////////////////
//						  RetroCMS							//
//<<<<<<<<<<<<<< The Oldschool Era is Back >>>>>>>>>>>>>>>>>//
//----------------------------------------------------------//
// Developed by: Marcos [ aka: m.tiago ]					//				
// Development Thread: goo.gl/nwzdZo						//
//////////////////////////////////////////////////////////////
// Beta Version 0.9.0 ( Aquamarine ) 					    //
// Branch: Public (Unstable)								//
// Compatibility Version(s): [r14,r15,r16,r17]				//
//////////////////////////////////////////////////////////////

// Class: Habbo Model
// Desc: DAO Content of habbo user Object

class HabboModel extends ModelTemplate{

	public function __construct($hotelConection){
		
		//Setting PDO Conection
		$this->hotelConection = $hotelConection;
		
	}

	//Get a Habbo Object by Value where type can be { 1 - by Id | 2 - by Name }
	public function get_HabboObject($value,$type){

		//Get Value by Type
		switch($type){
			case 1:
				$resultQuery = ($this->getById('users',$value) != false) ? $this->getById('users',$value) : false;
				break;
			case 2:
				$resultQuery = (count($this->getByParam('users','username',$value)) > 0) ? $this->getByParam('users','username',$value)[0] : false;
				break;		
		}

		//Construct Object 
		if($resultQuery){
			//Empty Habbo Object
			$habboObject = new Habbo();
			$habboObject->constructObject($resultQuery['id'],$resultQuery['username'],$resultQuery['password'],$resultQuery['rank'],$resultQuery['figure'],$resultQuery['sex'],$resultQuery['credits'],array($resultQuery['club_subscribed'],$resultQuery['club_expiration'],count($this->getByParam('users_club_gifts','user_id',$resultQuery['id']))),$resultQuery['user_language']);
			return $habboObject;
		}else{
			return false;
		}
	}
	
	
	//Get habbo session
	public function get_SessionStatus($sessionData){
		//If recieved session data 
		if(!$sessionData){
			return false;
		}else{
			//MySQL Query
			$resultQuery = $this->getById('site_sessions',$sessionData[1]) ? $this->getById('site_sessions',$sessionData[1]) : false;
			
			//If not found a ticked
			if(!$resultQuery){
				return false;
			}else{
				//If founded ticket and not expired yet 
				return ((date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) < date("Y-m-d H:i:s", strtotime('+12 hours', strtotime($resultQuery[2]))) ) &&  ($resultQuery[1] == $sessionData[0])) ? true : false;

			}
		}
	}
	
	//Set Habbo Login
	public function set_habboLogin($testObject){

		//New Habbo
		$habboObject = new Habbo();
		
		//Get all content from table (users) where Column(username) as equal habboObject username
		$resultQuery = $this->getByParam('users','username',$testObject->get_HabboName());
		
		//If found the habbo
		if(count($resultQuery) == 1){
			$habboObject->constructObject($resultQuery[0]['id'],$resultQuery[0]['username'],$resultQuery[0]['password'],$resultQuery[0]['rank'],$resultQuery[0]['figure'],$resultQuery[0]['sex'],$resultQuery[0]['credits'],array($resultQuery[0]['club_subscribed'],$resultQuery[0]['club_expiration'],count($this->getByParam('users_club_gifts','user_id',$resultQuery[0]['id']))),$resultQuery[0]['user_language']);
			//Check if password match
			if(sodium_crypto_pwhash_str_verify($habboObject->get_HabboPassword(), $testObject->get_HabboPassword())){
				//If Habbo have a permanent ban
				if($habboObject->get_HabboRank() == 0){
					//Habbo have been 
					return array(false,4);	
					exit;
				}else {
					//Habbo have been temporary banned (TODO)
					/*
					$resultQuery = $this->getByParam();
					if(true){
					return array(false,3);	
					exit;
					}
					*/
				}
			}else{
				
				//Password wrong
				return array(false,2);
				exit;
			}
			
		}else{
			//Habbo not exists
			return array(false,1);
			exit;
		}
		//If everthing ok just return true no-problem with habbo 
		
		//Get a Valid Login Ticket
		$habboObject->set_habboSession($this->get_ValidTicket('LT',$habboObject));	
		
		//Set the Login Ticket on Database
		$this->set_HabboTicket('LT',$habboObject);
		
		return array(true,0);
	}


	//Return a valid Habbo Ticket
	public function get_ValidTicket($type,$habboObject){
		$uniqueTicket = true;
		switch($type){
			
			//Login Ticket
			case 'LT':
				$resultQuery = $this->getColumn('site_sessions','id');
				$uniqueTicket = true;
				do{
					$ramdomTicket = 'LT-'.rand (100000 , 999999 ).'-'.bin2hex(random_bytes(10)).'-'.strtolower($habboObject->get_HabboLanguage()).'-fe2';
					foreach($resultQuery as $existingTicket){
						if($ramdomTicket == $existingTicket){
							$uniqueTicket = false;
						}
					}
				}while($uniqueTicket == false);
				
				break;
				
			//Server Ticket
			case 'ST':
				$result = $this->getColumn('users','sso_ticket');
				if (count($result) > 0){
					$uniqueTicket = true;
					do{
						$ramdomTicket = 'ST-'.rand (100000 , 999999 ).'-'.bin2hex(random_bytes(10)).'-'.strtolower($habboObject->get_HabboLanguage()).'-fe2';
						foreach($result as $existingTicket){
							if($ramdomTicket == $existingTicket){
								$uniqueTicket = false;
							}
						}
					}while($uniqueTicket == false);
				
				}
				break;
		}
		return $ramdomTicket;
	}
	
	public function set_HabboTicket($type,$habboObject){
		switch($type){
			
			//Set Login ticket on site_sessions
			case 'LT':
				$sql = "INSERT INTO site_sessions (`id`, `username`, `created_at`) VALUES (:id, :username,:created_at); 
				";
				try{
					$stmt = $this->hotelConection->prepare($sql);
					$stmt->bindValue(':id', $habboObject->get_habboSession()[1]);
					$stmt->bindValue(':username', $habboObject->get_habboId());
					$stmt->bindValue(':created_at', date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']));
					$stmt->execute();
				}catch (PDOException $e){
					echo "Erro during create user";
				}
				break;
			
			//Set Server ticked on field SSO of username row
			case 'ST':
				return $this->setColumnById('users', 'sso_ticket', $habboObject->get_HabboId(), $habboObject->get_HabboTicket());
				break;
		}
	}
	
	
	public function set_HabboRegistration($habboObject){
		$status = true;
		$sql = "INSERT INTO users (`username`, `password`, `figure`,`pool_figure`, `sex`, `motto`,`rank`, `birthday`,`email`) 
		VALUES (:habboname, :password , :figure,'', :gender, '', :rank, :birth,:email);
		";
		try{
			$stmt = $this->hotelConection->prepare($sql);
			$stmt->bindValue(':habboname', $habboObject->get_HabboName());
			$stmt->bindValue(':password', sodium_crypto_pwhash_str($habboObject->get_HabboPassword(), SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE));
			$stmt->bindValue(':figure', $habboObject->get_HabboFigure());
			$stmt->bindValue(':gender', $habboObject->get_HabboGender());
			$stmt->bindValue(':rank', $habboObject->get_HabboRank());
			$stmt->bindValue(':birth', $habboObject->get_HabboBirth());
			$stmt->bindValue(':email', $habboObject->get_HabboEmail());
			$stmt->execute();
		}catch (PDOException $e){
			echo "Erro during create user";
			$status = false;
		}
		
		return $status;
	}
}
?>