<?php
namespace BuildMyCV\classes ;

/**
* a classic User with classics properties (firstname, phone, etc..) and also many
* professionalExperiences loaded from json file
*/
class User
{
    private $firstname;
    private $lastname;
    private $email;
    private $phone;
    private $address;
    private $birth_date;
    private $town_birth;

    private $comptencies = array();

    private $professionalExperiences = array();
    private $personalExperiences = array();
    private $diplomas = array();
    private $trainings = array();
    private $langages = array();

    private $links = array();

    private static $instance;


    /**
    * Singleton class
    * @return an instance of User
    */
    public static function getInstance():User{
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
    function complete_name():string{
        return $this->lastname." ".$this->firstname ;
    }
    
    
    function birth_informations(){
        return 'né le '.$this->birth_date->format('d/m/Y').' à '.$this->town_birth;
    }
    
    function get_address(){
        return $this->address;
    }


    /**
    * create a balise tag to call this user
    * @return string as <a> tag
    */
    function phone_link():string{
        return '<a href="tel:'.$this->phone.'" >'.$this->phone.'</a>' ;
    }

    /**
     * print a link tag to send an email
     * @return string
     */
    function email_link():string{
        return '<a href="mailto:'.$this->email.'?subject=Votre%20CV">'.$this->email.'</a>';
    }
    
    function get_diplomas(){
        foreach ($this->diplomas as $diploma){
            yield $diploma;
        }
    }
    
    function get_trainings(){
        foreach ($this->trainings as $training){
            yield $training;
        }
    }
    
    function get_langages(){
        foreach ($this->langages as $lang){
            yield $lang;
        }
    }

    /**
    * create Html links in the contact area as <ul> tag
    * @return String
    */
    function print_links():string{
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
    function image(int $size=200):string{
        $src = "https://www.gravatar.com/avatar/".md5( strtolower( trim( $this->email ) ) )."?s=".$size;
        return '<img class="user" src="'.$src.'" alt="picture of '.$this->complete_name().'"/> ' ;
    }


    /**
     * find personnal or professionnal activity by name
     * @param string $name as activity name
     * @return Activity as activity searched
     */
    public function get_activity_by_name(string $name):Activity{
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
    private function print_link(string $name, array $details):string{
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