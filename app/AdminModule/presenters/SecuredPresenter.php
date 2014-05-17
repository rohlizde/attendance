<?php

namespace App\AdminModule;

class SecuredPresenter extends PublicPresenter {

    public $public_key;
    public $client_id;
    public $public_key_unh;

//public $public_key_hash;
    protected function startup() {
        if ($this->name != 'Admin:Sign') {
            if (!$this->user->isLoggedIn()) {
                $this->redirect('Sign:in', array(
                    'backlink' => $this->storeRequest()
                ));
            } else {
                //dd($this->name.$this->action,'d');exit;
                if (!$this->user->isAllowed($this->name, $this->action)) {
                    //dump('shit');exit;
                    $this->flashMessage('Access denied');
                    $this->redirect('Homepage:');
                } else {
                    exit;
                }
            }
        }
    }

    public function overitPublicKey($public_key, $public_key_unh) {
        $public_key_hash = $this->publicKeyHash($public_key_unh);
        if ($public_key == $public_key_hash) {
            return true;
        } else {
            return false;
        }
    }

    public function publicKeyHash($public_key) {

        $key = md5($public_key);

        return $key;
    }

    public function overitIdaKey($id, $key) {
        if ($id != $this->client_id) {
            return FALSE;
        }
        if ($key != $this->public_key) {
            return FALSE;
        }
        return true;
    }

}
