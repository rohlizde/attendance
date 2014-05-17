<?php

/**
 * Base presenter for all application presenters.
 */
use Nette\Application\UI\Form;
abstract class BasePresenter extends Nette\Application\UI\Presenter {
    /**
     *
     * @var \Model\UserModel
     */
    protected $userModel;
    /**
     *
     * @var App\SessionCreator
     */
    protected $session;
    public function startup() {
        parent::startup();
        //setters
        $this->session = new App\SessionCreator($this);
        $this->userModel = new \Model\UserModel;
        $this->setFBLogin();
        $this->user->getStorage()->setNamespace('front');
        
        //dump();exit;
        if ($this->name != 'Front:Sign') {
            if (!$this->user->isLoggedIn()) {
                $this->redirect('Sign:in', array(
                    'backlink' => $this->storeRequest()
                ));
            } 
            else {
                //dd($this->name.$this->action,'d');exit;
                if (!$this->user->isAllowed($this->name, $this->action)) {
                    //dump('shit');exit;
                    $this->flashMessage('Access denied');
                    $this->redirect('Homepage:');
                }
                else{
                    //exit;
                }
            }
        }
        $this->template->presenter = $this->getPresenter()->getName();
        $this->template->facebookLoginUrl = $this->context->facebook->getLoginUrl();
        dd($this->user->getIdentity(), 'user');
        // is cache allowed?
        
    }
    public function renderDefault(){
        
    }
    protected function createComponentSignInForm() {
        $form = new App\FrontModule\SignInForm();
        $form->onSuccess[] = $this->signInFormSubmitted;
        return $form;
    }
    public function signInFormSubmitted($form)
    {
            try {
                    

            } catch (\Nette\Security\AuthenticationException $e) {
                    $form->addError($e->getMessage());
            }
    }
    /**
     * Vytvoření odkazu pro facebook přihlášení
     */
    public function setFBLogin(){
        // facebook
		$fbUrl = $this->context->facebook->getLoginUrl(array(
			'scope' => 'email',
			'redirect_uri' => $this->link('//fbLogin'), // absolute
                        'token' => '089151913d3b8e18fbd745d7786090ce'
		));
		$this->template->fbUrl = $fbUrl;
    }
}
