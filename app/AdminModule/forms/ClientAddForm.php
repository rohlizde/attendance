<?php
namespace AdminModule;
use Nette\Application\UI\Form;

class ClientAddForm extends \BaseForm
{
    public function __construct($values = null) {
        parent::__construct();
        
        $this->addText('public_key', 'Public key: ');
        $this->addText('email', 'E-mail: ');
        $this->addText('limit_newsletter_sent', 'Limit_newsletter_sent: ');
        $this->addText('user', 'Uživatel: ');
        $this->addText('pass', 'Heslo: ');
        $this->addSubmit('submit', 'Uložit');
        if(isset($values))
        {
            $this->setDefaults($values);
        }
        
    }
}

?>
