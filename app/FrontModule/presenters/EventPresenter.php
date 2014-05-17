<?php
namespace App\FrontModule;
/**
 * Description of EventPresenter
 *
 * @author Rohlajz
 */
use Nette,Model;
use Model\Constant;

class EventPresenter extends \BasePresenter {

    public function actionDefault() {
    }

    public function renderDefault() {
        /*if($this->user->isInRole(Constant::SMANAGER)){
            
        }*/
        parent::renderDefault();
    }

}