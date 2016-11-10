<?php
namespace BuildMyCV\classes ;

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

    private static $instance;


    /**
    * Singleton class
    */
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new User();
        }
        return self::$instance ;

    }

	
    private function __construct() {
        $String = file_get_contents(ROOT."/src/public/data.json");
        $this->hydrate( json_decode($String, true) );
    }


    /**
    * get the complete name formated like `Rousseau Alexandre`
    * @return String
    */
    function complete_name(){
        return $this->lastname." ".$this->firstname ;
    }
    
    
    /**
    * create a balise tag to call this user
    * @return string as <a> tag
    */
    function phone(){
        return '<a href="tel:'.$this->phone.'" >'.$this->phone.'</a>' ;
    }


    /**
    * create Html links in the contact area as <ul> tag
    * @return String
    */
    function print_links(){
        $html = '' ;
        foreach ($this->links as $name => $details) {
            $html = $html.$this->print_link($name, $details);
        }
        return $html;
    }


    /**
    * create a Html picture of user from gravatar (snippet from https://fr.gravatar.com/site/implement/images/php)
    * @return String as html image tag from gravatar.com
    */
    function image($size=200){
        $src = "https://www.gravatar.com/avatar/".md5( strtolower( trim( $this->email ) ) )."?s=".$size;
        return '<img class="user" src="'.$src.'" alt="picture of '.$this->complete_name().'"/> ' ;
    }


    /**
    * Convert all comptencies in json format to use in javascript
    * @return String
    */
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


    /**
    * get all activities (Personnal AND professionnal experiences) sorted by date
    * @return array of Experience objects
    */
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

    /**
     * find personnal or professionnal activity by name
     * @param string $name as activity name
     * @return Activity as activity searched
     */
    public function get_activity_by_name($name){
        $activity_name =  Activity::urldecode($name);
        foreach($this->activities() as $activity){
            if($activity->name == $activity_name){ return $activity ; }
        }
        return null ;
    }
    
    /**
    * create link tag for User::print_links method
    * @return String links as <a .. ><img ... /></a>
    */
    private function print_link($name, $details){
        return '<a href="'.$details['link'].'"><img src="img/'.$details['img'].'" alt="'.$name.'"></a>';
    }


    /**
    * set up object properties in loop
    */
    private function hydrate(array $data){
        // setup user informations
        foreach ($data["user"] as $key => $value) {
            if( property_exists(get_class($this), $key )){
                // if it's a date, we set it as DatTime object
                $this->$key = (strpos($key, 'date')) ? \DateTime::createFromFormat('Y-m-d',$value) : $value ;
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