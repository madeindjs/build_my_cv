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
    private $kind;
    protected $technologies = array();
    private $tasks = array();
    
    const KIND_PERS = 'Personnal';
    const KIND_PRO  = 'Professionnal';

    
    function __construct(array $details){
        $this->hydrate($details);
    }
    
    /**
     * Compare Experiences by $end date
     * @param \BuildMyCV\classes\Experience $a
     * @param \BuildMyCV\classes\Experience $b
     * @return type
     */
    static function cmp(Experience $a, Experience $b){
        if($a->end && $b->end){
            return $a->end->getTimestamp() - $b->end->getTimestamp();
        }elseif($a->end){
            return $a->end->getTimestamp() - time() ;
        }elseif($b->end){
            return $b->end->getTimestamp() - time();
        }
        
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
    
    function get_kind(){return $this->kind;}


    /**
     * Set all attributes to this object
     * @param type $details
     */
    private function hydrate(array $details){
        $this->title = $details['title'] ?? null ;
        $this->begin = isset($details['begin'])?\DateTime::createFromFormat('Y-m-d',$details['begin']):null;
        $this->end =    isset($details['end'] ) ? \DateTime::createFromFormat('Y-m-d',$details['end'] ):null;
        $this->kind = $details['kind'] ?? null ;
        $this->company = $details['company'] ?? null ;
        $this->technologies = $details['technologies'] ?? null ;
        $this->tasks = $details['tasks'] ?? null ;
    }


    
}