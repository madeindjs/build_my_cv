<?php
/**
* a classic User with classics properties (firstname, phone, etc..) and also many
* professionalExperiences loaded from json file
*/
class User
{
	public $firstname;
	public $lastname;
	public $email;
	public $phone;
	public $adress;
	public $birth_date;
	public $town_birth;

	public $comptencies = array();

	public $professionalExperiences = array();
	public $personalExperiences = array();
	public $diplomas = array();
	public $trainings = array();
	public $langages = array();

	public $links = array();

	
	function __construct() {
		$string = file_get_contents("data.json");
		$this->hydrate( json_decode($string, true) );
	}

	/* return the complete name as `Rousseau Alexandre` */
	function complete_name(){
		return $this->lastname." ".$this->firstname ;
	}

	function print_links(){
		$html = '' ;

		foreach ($this->links as $name => $details) {
			$html = $html.$this->print_link($name, $details);
		}
		return $html;
	}

	/* return the image from gravatar.com
	snippet from https://fr.gravatar.com/site/implement/images/php */
	function image($size=200){
		$src = "https://www.gravatar.com/avatar/".md5( strtolower( trim( $this->email ) ) )."?s=".$size;
		return '<img src="'.$src.'" alt="picture of '.$this->complete_name().'"/> ' ;
	}


	// return an array
	function compentencies_to_json(){

		$json = array();

		$json['labels'] = array_keys($this->competencies) ;
		$json['datasets'][0] = array();
		$json['datasets'][0]['data'] = array();
		$json['datasets'][0]['backgroundColor'] = array();

		foreach ($this->competencies as $langage => $data) {
			array_push( $json['datasets'][0]['data'], $data['value'] );
			array_push( $json['datasets'][0]['backgroundColor'], $data['color'] );
		}

		return json_encode( $json , JSON_PRETTY_PRINT);

	}


	public function activities(){
		$array = array();
		foreach ($this->professionalExperiences as $exp){
			foreach ($exp->activities as $activity) {array_push($array, $activity); }
		}
		foreach ($this->personalExperiences as $exp){
			foreach ($exp->activities as $activity) {array_push($array, $activity); }
		}

		usort($array, function($a, $b) {if ($a->begin == $b->begin) {return 0; }else{ return ($a->begin > $b->begin) ? -1 : 1; } } );

		return $array ;
	}


	public function activities_to_json(){
		return json_encode( $this->activities_to_array() , JSON_PRETTY_PRINT);
	}


	/*
	* set up object properties in loop
	*/
	private function hydrate(array $data){
		// setup user informations
		foreach ($data["user"] as $key => $value) {
			if( property_exists(get_class($this), $key )){
				// if it's a date, we set it as DatTime object
				$this->$key = (strpos($key, 'date')) ? DateTime::createFromFormat('Y-m-d',$value) : $value ;
			}
		}
		// setup other properties 
		foreach ($data["professional experience"] as $key => $value) {
			array_push($this->professionalExperiences, new Experience($key, $value, true));
		}
		foreach ($data["personal experience"] as $key => $value) {
			array_push($this->personalExperiences, new Experience($key, $value, false));
		}
		foreach ($data["diplomas"] as $key => $value) {
			array_push($this->diplomas, new Qualification($key, $value));
		}
		foreach ($data["trainings"] as $key => $value) {
			array_push($this->trainings, new Qualification($key, $value));
		}
		foreach ($data["langages"] as $key => $value) {
			array_push($this->langages, new Langage($key, $value));
		}
		$this->competencies = $data["competencies"] ;
		$this->links = $data['links'] ;
	}
}