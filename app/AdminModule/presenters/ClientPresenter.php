<?php
namespace App\AdminModule;
class ClientPresenter extends SecuredPresenter
//class ClientPresenter extends Se
{

    public $klienti;
    public $editForm;
    public $public_key;
    public $public_key_unh;
    public $client_id;

    protected function startup()
    {
        parent::startup();
//        if(!$this->user->isAllowed($this->name, $this->action))
//            {
//                $this->flashMessage('Nepovolený přístup', 'warning');
//                $this->redirect('Sign:in');
//                
//            }
        $this->klienti = $this->context->createClient();
    }

    public function actionDefault()
    {
        
    }

    public function renderDefault()
    {
        $this->template->klienti = $this->klienti;
    }

    public function actionAdd()
    {
        
    }

    protected function createComponentClientAddForm()
    {
        $form = new ClientAddForm();
        $form->onSuccess[] = callback($this, 'clientAddFormSubmitted');
        return $form;
    }

    public function clientAddFormSubmitted(ClientAddForm $form)
    {
        $values = $form->getValues();
        dd($values);
        $klient = $this->klienti->insert(array(
            'public_key' => $values->public_key,
            'limit_newsletter_sent' => $values->limit_newsletter_sent,
            'email' => $values->email,
                ));
        $this->context->createUzivatel()->insert(array(
            'username' => $values->user,
            'password' => $this->heslo($values->pass),
            'client_id' => $klient->client_id,
        ));
        
        //vytvořit adresář na přílohy
        $dir = ATTACHMENTS_DIR.'/'.$klient->client_id; 
        mkdir($dir);
        
        $this->redirect('Client:');
    }

    public function renderAdd()
    {
        
    }

    public function actionRemove($id)
    {
        $this->context->createUzivatel()->where('id', $id)->delete();
        $this->klienti->where('client_id', $id)->delete();

        $this->redirect('Client:');
        //TODO: js potvrzení
    }

    public function actionEdit($id)
    {
        $this->public_key = $id;
    }

    protected function createComponentClientEditForm()
    {
        $values = $this->klienti->where('client_id', $this->public_key)->fetch();
        $form = new ClientAddForm($values);
        dd($values, 'hodnoty z databáze');
        $form->onSuccess[] = callback($this, 'clientEditFormSubmitted');
        return $form;
    }

    public function clientEditFormSubmitted(ClientAddForm $form)
    {
        $values = $form->getValues();
        $this->klienti->where('client_id', $this->public_key)->update(array(
            'public_key' => $values->public_key,
            'limit_newsletter_sent' => $values->limit_newsletter_sent,
        ));
        $this->redirect('Client:');
    }

    public function heslo($pass)
    {
        $heslo= md5($pass . str_repeat('uzivatel', 10));
        dd($heslo, 'zahešované heslo');
                dd($pass, 'původní heslo');
		return $heslo;
    }

}