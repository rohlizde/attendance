<?php

namespace App\FrontModule;

use Nette\Application\UI\Form;
use Nette\Security\IIdentity;
use App\SessionCreator;

class SignPresenter extends \BasePresenter {
   
    public function actionIn() {
        
    }
    /**
     * Facebook login
     */
    public function actionFbLogin() {
        $me = $this->context->facebook->api('/me');
        //dd($me,'me');exit;
        $identity = $this->context->facebookAuthenticator->authenticate($me);
        //dd($identity, 'ide');exit;=
        $this->getUser()->login($identity);
        $this->flashMessage('Uživatel byl úspěšně přihlášen.', 'success');
        $this->redirect('Homepage:');
    }
    /**
     * Odhlášení uživatele
     */
    public function actionOut() {
        $this->getUser()->logout();
        $this->flashMessage('Uživatel byl odhlášen.');
        $this->redirect('Homepage:');
    }

}
