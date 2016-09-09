<?php
require_once('ProfessionalExperience.php');
/**
* a classic User with classics properties (firstname, phone, etc..) and also many
* professionalExperiences loaded from json file
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

	/* return the complete name as `Rousseau Alexandre` */
	function complete_name(){
		return $this->lastname." ".$this->firstname ;
	}
}