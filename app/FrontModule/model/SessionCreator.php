<?php
/**
 * Třída pro vytvoření session pro uživatele
 *
 * @author Rohlajz
 */
namespace App;
class SessionCreator {
    /**
     *
     * @var \Nette\Application\UI\Presenter
     */
    private $presenter;
    /**
     * 
     * @param \Nette\Application\UI\PresenterComponent $presenter
     */
    public function __construct(\Nette\Application\UI\PresenterComponent $presenter) {
        $this->presenter = $presenter;
    }
    
    public function setSession($name, array $args){
        $name = $this->presenter->getSession($name);
        foreach($args as $key => $value){
            $name['key'] = $value;
        }
    }
}
