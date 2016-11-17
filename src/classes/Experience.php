<?php
namespace BuildMyCV\classes ;


/**
* An Experience is a moment passed in a Company or in a personnal project
* with one or multiple technologies
*/
class Experience extends Entity
{
    protected $begin;
    protected $end;
    private $company;
    private $technologies = array();
    private $tasks = array();

    
    function __construct(array $details){
        $this->hydrate($details);
    }

    /**
    * create title with job title & company
    * @return String
    */
    protected function complete_title():string{
        return $this->company ? $this->title.' @ '.$this->company : $this->title ;
    }
    
    
    protected function tasks_to_html():string{
        $ret = '<ul>';
        foreach ($this->tasks as $task){
            $ret .= '<li>'.$task.'</li>';
        }
        return $ret.'</ul>';
    }


    /**
     * Set all attributes to this object
     * @param type $details
     */
    private function hydrate(array $details){
        $this->title = $details['title'] ?? null ;
        $this->begin = \DateTime::createFromFormat('Y-m-d',$details['begin']);
        $this->end = isset($details['end']) ? \DateTime::createFromFormat('Y-m-d',$details['end']) : null;
        $this->company = $details['company'] ?? null ;
        $this->technologies = $details['technologies'] ?? null ;
        $this->tasks = $details['tasks'] ?? null ;
    }


    
}