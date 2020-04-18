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


// Class: ControllerTemplate
// Desc: Default Template for Controllers


namespace Template;

class Controller{
	
	protected $pageTitle;
	protected $habbo;
	protected $habboModel;		
	protected $hotel;
	protected $hotelModel;
	
    function __construct(){

		//Default Page Title
		$this->pageTitle = 'Habbo';
		
		//Set_Deafult Body Id
		$this->bodyId = 'home';
		
		//Intercept MVC Requests based on some conditions (Version | Rank | Hotel Status)
		$this->requestIntercept();
		
	}

	private function requestIntercept(){
	
		//Is Hotel Installed ?
		if(true){
			if(get_class($this) == 'Controller\Install' || 1==2){
				header('Location: '.$this->hotel->get_HotelUrl());	
			}
		}else if(get_class($this) != 'Controller\Install'){
			header('Location: '.$this->hotel->get_HotelUrl().'/install/start');
		}
	}
}

?>