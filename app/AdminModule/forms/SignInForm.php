<?php
namespace App\AdminModule;
use Nette\Application\UI\Form;
class SignInForm extends \BaseForm
{
    public function __construct($values = NULL)
    {
        parent::__construct();
        $this->addText('email', 'Email')
                ->setRequired('Prosím zadejte email.')
                ->addRule(Form::EMAIL, "Zadejte validní emailovou adresu.");

        $this->addPassword('password', 'Password:')
                ->setRequired('Prosím zadejte heslo.');

        $this->addCheckbox('remember', 'Trvalé přihlášení');

        $this->addSubmit('submit', 'Přihlásit');
        if(isset($values))
        {
            $this->setDefaults($values);
        }
    }
}