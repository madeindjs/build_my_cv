<?php

/**
* 
*/
class User
{
	public $firstname;
	public $lastname;
	
	function __construct($json_file)
	{
		$string = file_get_contents($json_file);
		$data = json_decode($string, true);

		$this->lastname = $data["user"]["lastname"] ;
		$this->firstname = $data["user"]["firstname"] ;

	}

	function complete_name(){
		return $this->lastname." ".$this->firstname ;
	}
}