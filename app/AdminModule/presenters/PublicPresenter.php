<?php
namespace App\AdminModule;
/**
 * Description of PublicPresenter
 *
 * @author Jana
 */
class PublicPresenter extends \Nette\Application\UI\Presenter
{

    /**
     * (non-phpDoc)
     *
     * @see Nette\Application\Presenter#startup()
     */
    public function handleSignOut() {
        $this->getUser()->logout();
        $this->redirect('Sign:in');
    }

    public function startup() {
        parent::startup();
        $this->user->getStorage()->setNamespace('admin');
    }

}