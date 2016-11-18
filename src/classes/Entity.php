<?php
namespace BuildMyCV\classes;

/**
 * An entity can be:
 * - a professionnal experience
 * - a peronnal experience
 * - a diplomas
 * - a training 
 */
abstract class Entity {
    
    protected $title;
    
    /**
     * generate an Html represention of this Entity. It will generate something like this:
     * <date>{date formated}</date>
     * <strong>{title formated}</strong>
     * <ul><li>{task}</li>(...)</ul>
     * <div><img .. {picture of technologies} /></div>
     * @return string
     */
    function to_html():string{
        $ret =  '<date>'.$this->work_interval().'</date><strong>'.$this->complete_title().'</strong>' ;
        // add technologies if Entity is an Experience
        if(property_exists(get_class($this), 'technologies')){
            $ret .= '<div class="technologies" >';
            foreach ( $this->technologies as $skill_name ){
                /* @var $skill BuildMyCV\classes\Skill */
                $skill = new Skill($skill_name);
                $ret .= $skill->picture_to_html();
            }
            $ret .= "</div>";
        }
        // add tasks list if Entity is an Experience
        if(method_exists(get_class($this), 'tasks_to_html' )){
            $ret .= $this->tasks_to_html();
        }
        return $ret ;
    }
    
    /**
     * Returned a formated time intervall 
     * @return string
     */
    protected function work_interval():string{
        if( property_exists(get_class($this), 'date' )){
            return $this->date ? $this->date->format('Y') : "?";
        }else{
            // if begin & end year is the same, we only print year
            if($this->end && $this->begin->format('Y') == $this->end->format('Y')){
                return $this->begin->format('Y');
            
            // elseif different but we have an end year, print both in '2015-16' format
            }elseif ($this->end && $this->begin ) {
                return $this->begin->format('Y').'-'.$this->end->format('y');
                
            // else print in '2015-16' format with current year
            }else{
                return $this->begin ? $this->begin->format('Y').'→' : "?";
            }
        }
    }
    
    protected function complete_title(){
        throw new NotImplementedException();
    }
}


class NotImplementedException extends \RuntimeException { }