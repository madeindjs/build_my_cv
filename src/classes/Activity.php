<?php
namespace BuildMyCV\classes ;

require_once ROOT.'/vendor/erusev/parsedown/Parsedown.php';
/**
* An activity is a task done during a job. 
* it contains a picture & a description
*/
class Activity
{
    public $name;
    public $description;
    public $begin;
    public $picture;

    private $parent ;

    /**
     * Construct an Activity based on details and his parent
     * @param \BuildMyCV\classes\Experience $parent as Activity's parent
     * @param string $name
     * @param array $details
     */
    function __construct(Experience $parent, string $name, array $details){
        $this->parent = $parent;
        $this->begin = \DateTime::createFromFormat('Y-m-d',$details['begin']);
        $this->name = $name;
        $this->picture = $details['img'];
        $this->description = array_key_exists('description' , $details ) ? $details['description'] : null ;
    }


    /* 
    * create a Html picture of user from gravatar (snippet from https://fr.gravatar.com/site/implement/images/php)
    * @return string as html image tag from gravatar.com
    */
    function title():string{
        if($this->parent->professional_exp){
            return $this->link().'<small> chez '.$this->parent->name .'</small>';
        }else{return $this->link().'<small> (experience personnelle)</small>';}
    }


    /* 
    * create an Html <date> formated
    * @return String
    */
    function date(): string{
        return '<date>'.$this->begin->format('m/Y').'</date>';
    }


    /* 
    * create an Html description parsed in Markdown
    * @return String
    */
    function description():string{
        $Parsedown = new \Parsedown();
        return $Parsedown->line($this->description);
    }


    /* 
    * create a Html picture of user from gravatar (snippet from https://fr.gravatar.com/site/implement/images/php)
    * @return string as html image tag from gravatar.com
    */
    function picture():string{
        return '<img src="/img/'.$this->picture.'" alt="logo of this Activity" >';
    }


    /*
    * create a complete Html <div> with all information about this object
    * @return String
    */
    function to_html():string{
        $Parsedown = new Parsedown();
        return '<li>'.$this->picture().$Parsedown->text($this->description).'</li>';
    }


    function to_array():array{
        $Parsedown = new Parsedown();
        $ret = array();
        $ret['name'] = $this->title();
        if($this->description){$ret['description'] = $Parsedown->text($this->description) ;}
        $ret['img'] = 'img/'.$this->picture ;
        $begin = $this->begin ? $this->begin : new \DateTime() ;
        $ret['date'] = $begin->format('Y-m-d');
        return $ret ;
    }
        
    /**
     * Create a link to the project
     * @return string as Html link
     */
    function link():string{
        return '<a href="/activity/'.$this->urlencode($this->name).'">'.$this->name.'</a>';
    }
    
    
    /**
     * Return activity name encoded to be used as link
     * @return string as url encoded
     */
    private function urlencode(string $link):string{
        $sanitize_project_name = str_replace('/', '_', $link);
        return urlencode($sanitize_project_name);
    }
    
    /**
     * Return activity name decoded from url
     * @param string $link as url param
     * @return string as url encoded
     */
    public static function urldecode(string $link):string{
        $sanitize_project_name = str_replace('_', '/', $link);
        return urldecode($sanitize_project_name);
    }
        
}