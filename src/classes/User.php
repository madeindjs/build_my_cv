<?php
namespace BuildMyCV\classes ;

/**
* a classic User with classics properties (firstname, phone, etc..) and also many
* professionalExperiences loaded from json file
*/
class User
{
    private static $instance;
    
    private $firstname;
    private $lastname;
    private $email;
    private $phone;
    private $address;
    private $birth_date;
    private $town_birth;
    private $oneline_description ;
    private $multiline_description ;
    
    private $interest_points = array();

    private $programming_langages = array();
    private $frameworks = array();

    private $experiences = array();
    private $qualifications = array();
    private $skills = array();
    private $langages = array();
    private $links = array();
    
    const JSON_URL = ROOT."\\src\\public\\data.json" ;

    /**
    * Singleton class
    * @return an instance of User
    */
    public static function get_instance():User{
        if(is_null(self::$instance)){
            self::$instance = new User();
        }
        return self::$instance ;

    }

	
    private function __construct() {
        if(file_exists(self::JSON_URL)){
            $data = file_get_contents(self::JSON_URL);
            $this->hydrate( json_decode($data, true) );
        }else{
            throw new \Exception( self::JSON_URL.' does not exist');
        }
    }
    
    /* GETTERS AREA */
    function get_firstname():string{ return $this->firstname; }
    function get_lastname():string{ return $this->lastname; }
    function get_address():string{ return $this->address; }
    function get_email():string{ return $this->email; }
    function get_phone():string{ return $this->phone; }
    function get_birth_date(): \DateTime{ return $this->birth_date; }
    function get_town_birth():string{ return $this->town_birth; }
    function get_diplomas(){
        return $this->items_from_this_kind($this->qualifications, Qualification::KIND_DIPLOMAS);
    }
    function get_trainings(){
    }
    function get_langages():array{ return $this->langages; }
    function get_professional_experiences(){
        return $this->items_from_this_kind($this->experiences, Experience::KIND_PRO);
    }
    function get_personal_experiences(){
        return $this->items_from_this_kind($this->experiences, Experience::KIND_PERS);
    }
    
    function get_interest_points(){return $this->interest_points;}
    function get_programming_langages(){
        return $this->items_from_this_kind($this->skills, Skill::KIND_LANG);
    }
    function get_frameworks(){
        return $this->items_from_this_kind($this->skills, Skill::KIND_FRAMEWORK);
    }
    function get_oneline_description():string{ return $this->oneline_description ;}
    function get_multiline_description():string{ return $this->multiline_description ;}

    /**
     * Return all items corresponding to the given kind of experience
     * @parma array $items as items to search in (experiences, qualifications, etc..)
     * @param string $kind
     * @yield Experience 
     */
    private function items_from_this_kind(array $items, string $kind){
        foreach ($items as $exp){
            if($exp->get_kind() == $kind){
                yield $exp ;
            }
        }
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
    
    
    /**
    * create Html links in the contact area as <ul> tag
    * @yield String as string
    */
    function get_contacts_links(){
        foreach ($this->links as $n => $details) {
            yield self::contact_link_to_html($details);
        }
    }
    
    /**
    * create link tag for User::print_links method
    * @return String links as <a .. ><img ... /></a>
    */
    private static function contact_link_to_html(array $details):string{
        return '<a href="'.$details['link'].'">'.$details['name'].'</a>';
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
        foreach ($data["experiences"] as $key => $value) {
            array_push($this->experiences, new Experience($value));
        }
        foreach ($data["qualifications"] as $key => $value) {
            array_push($this->qualifications, new Qualification($value));
        }
        foreach ($data["skills"] as $key => $value){
            array_push($this->skills, new Skill($value));
        }
        foreach ($data["langages"] as $key => $value) {
            array_push($this->langages, new Langage($key, $value));
        }
        $this->links = $data['links'] ;
    }
}