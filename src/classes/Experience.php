<?php
namespace BuildMyCV\classes ;


/**
* An Experience is a moment passed in in a Company or in a personnal project
* It represent a collection of many activities in this job
*/
class Experience
{
    public $name;
    public $begin;
    public $end;

    public $activities = array();
    public $professional_exp ;

    function __construct(string $name, array $details, bool $professional_exp = false)
    {
        $this->name = $name;
        $this->professional_exp = $professional_exp;
        $this->begin = \DateTime::createFromFormat('Y-m-d',$details['begin']);
        $this->end = isset($details['begin']) ? \DateTime::createFromFormat('Y-m-d',$details['begin']) : null;

        foreach ($details["activities"] as $picture => $description) {
            array_push($this->activities, new Activity($this,$picture, $description )) ;
        }
    }

    /**
    * create title with title and date time
    * @return String
    */
    function title():string{
        if($this->begin) {
            return $this->name.' <small>le <time datetime="'.$this->begin->format('Y-m-d').'">'.$this->begin->format('d/m/Y').'</time></small>';
        }else{
            return $this->name;
        }
    }

    /**
    * @return array
    */
    function to_array():array{
        $ret = array();
        foreach ($this->activities as $activity) {
            array_push( $ret, $activity->to_array() );
        }
        return $ret ; 
    }


    /**
    * @return String
    */
    function to_json():string{
        return json_encode( $this->to_array() , JSON_PRETTY_PRINT);
    }
    
    

    
}