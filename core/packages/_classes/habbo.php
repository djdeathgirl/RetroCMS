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

// Class: Habbo
// Desc: All Habbo Data

class Habbo extends ClassTemplate{
	
	protected $habboId;
	protected $habboName;
	protected $habboPassword;
	protected $habboLoggedIn;
	protected $habboRank;
	protected $habboFigure;
	protected $habboGender;
	protected $habboCredits;
	protected $habboClub = [];
	protected $habboBirth;
	protected $habboLoggedStatus;
	
	public function __construct(){

	}

	/** DAO CONSTRUCT **/
	public function constructObject($id,$username,$password,$rank,$figure,$gender,$credits,$habboclub,$language){
		$this->habboId = $id;	
		$this->habboName = $username;	
		$this->habboPassword = $password;	
		$this->habboRank = $rank;	
		$this->habboFigure = $figure;	
		$this->habboGender = $gender;
		$this->habboCredits = $credits;
		$this->habboClub = $habboclub;
		$this->habboLanguage = $language;
				
	}
	
	/** GETS **/
	
	public function get_isHabboLoggedIn(){
		return $this->habboLoggedStatus;
	}
	
	public function get_strHabboLoggedIn(){
		return $this->get_isHabboLoggedIn() ? "true" : "false";
	}

	public function get_habboSession(){
		if(isset($_SESSION['habboLoggedId']) &&  isset($_SESSION['habboLoggedToken'])){
			
			//If logged set the ID
			$this->habboId = $_SESSION['habboLoggedId'];
			
			// + Set New Timeout for "habboWebsite"
			$_SESSION['habboLastActivity'] = $_SERVER['REQUEST_TIME'];
			
			//Return Array
			return array($_SESSION['habboLoggedId'],$_SESSION['habboLoggedToken']);
		}else{
			return false;
		}
	}

	public function get_HabboId(){
		return $this->habboId;
	}
	
	public function get_HabboName(){
		return $this->habboName;
	}

	public function get_HabboPassword(){
		return $this->habboPassword;
	}

	public function get_HabboRank(){
		return $this->habboRank;
	}
	
	public function get_HabboCredits(){
		return $this->habboCredits;
	}

	public function get_HabboFigure(){
		return 0;
	}

	public function get_HabboClub($requestId){
		switch($requestId){
			
			//If habbo have been part of HC
			case 1:
				if($this->habboClub[0]>0){
					return true;
				}else{
					return false;
				}
				break;
			
			//If habbo have hc days left (with prepaid periods)
			case 2:
				return   ((new DateTime(date("Y-m-d",$this->habboClub[1])))->diff(new DateTime(date("Y-m-d")))->format("%a")) > 0 ?(new DateTime(date("Y-m-d",$this->habboClub[1])))->diff(new DateTime(date("Y-m-d")))->format("%a") : 1;
				break;
				
			//Days left from the current pre-paid period (1 month)
			case 3:
				return ceil(((new DateTime(date("Y-m-d",$this->habboClub[1])))->diff(new DateTime(date("Y-m-d")))->format("%a") )/ 31);
				break;			
			
			
			
			//Pre-paid peridods
			case 4:
				$calc = (new DateTime(date("Y-m-d",$this->habboClub[1])))->diff(new DateTime(date("Y-m-d")))->format("%a");
				$calc = $calc % 31;
				$calc = (new DateTime(date("Y-m-d",$this->habboClub[1])))->diff(new DateTime(date("Y-m-d")))->format("%a") - $calc;
				$calc = $calc/31;
				return($calc);
			break;
			
			//Elapsed Periods
			case 5:
				if($this->get_HabboClub(1)){
					if($this->habboClub[2]-1 >= 0){
						return ($this->habboClub[2]-1);
					}else{
						return 0;	
					}
				}else{
					return($this->habboClub[2]);
				}
			break;
			
			case 6:
				return (new DateTime(date("Y-m-d",$this->habboClub[1])))->format('d-m-Y');
				break;
		}
	
			
	}

	
	public function get_isHomeVisible(){
		return true;
	}

	/** SETS **/
	public function set_isHabboLoggedIn($status){
		//Set the logged status
		$this->habboLoggedStatus = $status;
	}
	
	public function set_HabboSession($sessionToken){
		$_SESSION['habboLoggedId'] = $this->habboId;
		$_SESSION['habboLoggedToken'] = $sessionToken;
	}

	public function set_HabboLogout(){
		//Destroy Session
		session_unset();
		session_destroy();
	}
	
	public function set_HabboName($param){
		$this->habboName = $param;
	}
	
	
	public function set_HabboPassword($param){
		if(strlen($param) >= 6){
			$this->habboPassword = $param;
		}else{
			$this->habboPassword = null;	
		}
	}
	
	
}
?>