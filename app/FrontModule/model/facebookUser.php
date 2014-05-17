<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of facebookUser
 *
 * @author Rohlajz
 * 
 */
use \Nette\Security\IUserStorage;
use \Nette\Security\IAuthenticator;
use \Nette\Security\IAuthorizator;
use \Nette\Security\User;

class facebookUser extends User {
    /**
     * $facebook
     */
    protected $facebookUser = NULL;
    /**
     * 
     * @param \Nette\Security\IUserStorage $storage
     * @param \Nette\Security\IAuthenticator $authenticator
     * @param \Nette\Security\IAuthorizator $authorizator
     */
    public function __construct(IUserStorage $storage, IAuthenticator $authenticator = NULL, IAuthorizator $authorizator = NULL) {
        parent::__construct($storage, $authenticator, $authorizator);
    }
    /**
     * 
     * @param array $facebook
     */
    public function setFacebookUser(Array $facebook){
        $this->facebookUser = $facebook;
    }
    /**
     * 
     * @return type facebook
     */
    public function getFacebookUser(){
        return $this->facebookUser;
    }
    /**
     * 
     * @return boolean
     */
    public function isLoggedInFacebook(){
        if($this->facebookUser != NULL) return true;
        else return false;
    }
    /**
     * 
     * @return type boolean
     */
    public function isLoggedIn(){
        return $this->getStorage()->isAuthenticated();
    }
    /**
     * 
     * @param type $id
     */
    public function facebookLogin($id = NULL){
        $this->logout(TRUE);
        if (!$id instanceof IIdentity) {
                $id = $this->getAuthenticator()->authenticateFacebook(func_get_args());
        }
        $this->storage->setIdentity($id);
        $this->storage->setAuthenticated(TRUE);
        $this->onLoggedIn($this);
    }
    public function facebookLogout(){
        $this->facebookUser = NULL;
    }
}

?>
