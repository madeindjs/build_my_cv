<?php
namespace BuildMyCV\classes ;
/**
 * A skill is a programming Langage or a Framework mastered by user
 */
class Skill{
    private $name;
    private $score;
    
    const MAX = 10 ;
    
    function __construct(string $name, int $score) {
        $this->name = $name;
        $this->score = $score;
    }
    
    function __toString(){
        return $this->name.'('.$this->score.')'; 
    }

    /**
     * Render this skill to Html (name + progress bar)
     * @return string as Html tag
     */
    function to_html():string{
        return $this->name.$this->progress_bar_html();
    }
    
    /**
     * Render an Html progress bar for the score
     * @return string as Html tag
     */
    private function progress_bar_html():string{
        return '<progress value='.$this->score.' max="'.self::MAX.'">'.$this->score.'/'.self::MAX.'</progress>';
    }
}
