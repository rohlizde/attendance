<?php
/**
 * Description of UserPresenter
 *
 * @author Rohlajz
 */

namespace App\FrontModule;

use Nette,
    Model;
use Model\Constant;
use Nette\Application\UI\Form;
class UserPresenter extends \BasePresenter{

    /**
     * (non-phpDoc)
     *
     * @see Nette\Application\Presenter#startup()
     */
    public function startup() {
        parent::startup();
    }

    public function actionDefault() {
        
    }

    public function renderDefault() {
        if($this->user->isLoggedIn()){
            $this->flashMessage("Nastavení účtu.");
        }
        else{
            $this->flashMessage("Nejste přihlášen.");
            $this->redirect('Homepage:default');
        }
    }
    public function renderShow($id = NULL) {
        if($id == NULL){
            $this->template->users = $this->userModel->getFullUser();
            dd($this->template->users, 'usss');
        }
        else{
            $this->template->singleuser = $this->userModel->getFullUser(array(Constant::USER_ID => $id));
            if($this->template->singleuser == NULL){
                $this->flashMessage('Tento uživatel neexistuje.', 'warning');
                $this->redirect('User:show');
            }
        }
    }
}