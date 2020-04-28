<?php
//////////////////////////////////////////////////////////////
//						  RetroCMS							//
//<<<<<<<<<<<<<< The Oldschool Era is Back >>>>>>>>>>>>>>>>>//
//----------------------------------------------------------//
// Developed by: Marcos [ aka: m.tiago ]					//
// Development Thread: goo.gl/nwzdZo						//
//////////////////////////////////////////////////////////////
// Beta Version 0.9.5.110 ( Aquamarine ) 				    //
// Branch: Public (Unstable)								//
// Compatibility Version(s): [r14,r15,r16,r17]				//
//////////////////////////////////////////////////////////////


// Class: Hotel
// Desc:  Plain OLD CLR for Hotel 

namespace CLR;

use RetroRCON\RemoteConnection;

final class Habbo extends \Template\Shared{
	private $habboId;
	private $habboLoggedIn;
	private $habboName;
	private $habboPassword;
	private $habboRank;
	private $habboFigure;
	private $habboGender;
	private $habboCredits;
	private $habboLanguage;

	//Default Construct Method
    function __construct(){
		$this->habboLoggedIn = false;
	}
	
	function constructObject($habboId,$habboName,$habboPassword,$habboRank){
		$this->habboId = $habboId;
		$this->habboName = $habboName;
		$this->habboPassword = $habboPassword;
		$this->habboRank = $habboRank;
		$this->habboLanguage= 'EN';
		
		//If GRPC Enabled set a rCon based on Hotel Object Info
		$hotelConnection = ( extension_loaded("grpc") !== null && extension_loaded("grpc") ) ? new RemoteConnection(['host' => '127.0.0.1','port' => 12309]) : false;	
    }
	
	
	/** GETS **/

	public function get_HabboId(){
		return $this->habboId;
	}
	
	public function get_isHabboLoggedIn(){
		return $this->habboLoggedIn;
	}
	
	public function get_HabboName(){
		return $this->habboName;
	}

	public function get_habboSession(){
		return (isset($_SESSION['habboLoggedIn']) && isset($_SESSION['habboLoggedId']) &&  isset($_SESSION['habboLoggedToken'])) ? array($_SESSION['habboLoggedId'],$_SESSION['habboLoggedToken']) : false;
	}
	
	
	public function get_HabboPassword(){
		return $this->habboPassword;
	}
	
	public function get_HabboRank(){
		return $this->habboRank;
	}

	public function get_HabboFigure(){
		return $this->habboFigure;
	}
	
	public function get_HabboGender(){
		return $this->habboGender;
	}	

	public function get_HabboCredits(){
		return $this->habboCredits;
	}

	public function get_HabboClub(){
		return null;
	}
	/** SETS **/
	public function set_HabboId($param){
		$this->habboId = $param;
	}
	
	public function set_HabboSession(){
		$_SESSION['habboLoggedIn']  = true;
		$_SESSION['habboLoggedId'] = $this->habboId;
		$_SESSION['habboLoggedToken'] = $this->getValidTicket('LT',$this->habboLanguage);
	}

	public function set_HabboLogout(){
		$_SESSION['habboLoggedIn']  = false;
		unset($_SESSION['habboLoggedId']);
		unset($_SESSION['habboLoggedToken']);
	}
	
	public function set_isHabboLoggedIn($status){
		//Set the logged status
		$this->habboLoggedIn = $status;
		
		//Destroy session ticket for safety
		if(!$status){
			$_SESSION['habboLoggedIn'] = false;
			unset($_SESSION['habboLoggedId']);
			unset($_SESSION['habboLoggedToken']);
		}
	}
}

?>