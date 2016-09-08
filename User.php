<?php
require_once('ProfessionalExperience.php');
/**
* 
*/
class User
{
	public $firstname;
	public $lastname;
	public $professionalExperiences = array();
	
	function __construct($json_file)
	{
		$string = file_get_contents($json_file);
		$data = json_decode($string, true);

		$this->lastname = $data["user"]["lastname"] ;
		$this->firstname = $data["user"]["firstname"] ;

		foreach ($data["professional experience"] as $key => $value) {
			array_push($this->professionalExperiences, new ProfessionalExperience($key, $value));
		}

	}

	function complete_name(){
		return $this->lastname." ".$this->firstname ;
	}
}