<?php
namespace App\AdminModule;
use Nette\Application\UI,
    Nette\Application\UI\Form,
        Nette\Security as NS;

class SignPresenter extends PublicPresenter
{
public $public_key;
public $client_id;

	/**
	 * Sign in form component factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new SignInForm();
                $form->onSuccess[]=callback($this, "signInFormSubmitted");
                return $form;
	}



	public function signInFormSubmitted($form)
	{
		try {
                    $user = $this->getUser();
			$values = $form->getValues();
			if ($values->persistent){
                            $user->setExpiration("+30 days", false);
                        }
                        $user->login($values->username, $values->password);
                        $this->redirect("Client:");

		} catch (NS\AuthenticationException $e) {
			$form->addError("Neplatné uživatelské jméno nebo heslo.");
		}
	}



	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
