<?php

namespace App;

/**
 * ACL továrnička
 *
 * @author Rohlajz
 */
use Nette,
    Config;
use Model\Constant;

class Permission extends Nette\Security\Permission {

    /**
     * vytvoreni roli a zdroju
     */
    public function __construct() {
        $this->addRole('guest');
        $this->addRole('user', 'guest');
        $this->addRole('manager','user');
        $this->addRole('admin','manager');
        
//        todo pridani zdroju
        $this->addResource('Front:Homepage');
        $this->addResource('Front:Sign');
        $this->addResource('Front:User');
        $this->addResource('Front:Event');
        $this->addResource('Admin:Sign');
        $this->addResource('Admin:Homepage');
        $this->addResource('Admin:Default');
        
        $this->allow('guest', Permission::ALL);
        $this->deny('guest', 'Front:Homepage');
        $this->allow('user', 'Front:Homepage');
    }

}
