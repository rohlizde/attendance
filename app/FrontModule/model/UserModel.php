<?php

namespace Model;

use Nette,
    Nette\Utils\Strings;
use Nette\Security\Identity;

/**
 * Database model
 */
class UserModel {

    public function __construct() {
    }

    public function getUser(array $by) {
        return \dibi::select('*')
                ->from(Constant::TABLE_USER)
                ->innerJoin(Constant::TABLE_AUTH)->using('('.Constant::TABLE_AUTH_ID.')')
                ->where($by)
                ->fetch();
    }
    public function getFbUser(array $by){
        return \dibi::select('*')->from(Constant::TABLE_FB_USER)
                ->where($by)
                ->fetch();

    }

    public function updateUser(\DibiRow $user, array $values) {
        $query = \dibi::update(Constant::TABLE_USER, $values)
                ->where(Constant::USER_ID, $user->user_id)
                ->execute();
    }

    public function updateFbUser(array $values, array $by) {
        dd($values, 'values');
        \dibi::update(Constant::TABLE_FB_USER, $values)
                ->where($by)
                ->execute();
       
    }
    /**
     * 
     * @param array $values
     */
    public function registerUser(array $values) {
        // todo validate values
        \dibi::insert(Constant::TABLE_USER, $values)->execute();
        //return \dibi::getInsertId();
    }

    public function createIdentity(\DibiRow $user) {
        $data = $user->toArray();
        unset($user['password']);

        return new \Nette\Security\Identity($user->user_id, $user->key_name, $data);
    }
    
    public function insertFbUser(array $values){
        \dibi::insert(Constant::TABLE_FB_USER, $values)->execute();
    }
    /**
     * 
     * @param array $by
     * if null return all users
     * @return dibi result user join facebook join auth
     */
    public function getFullUser(array $by = NULL){
        $query =  \dibi::select('*')->from(Constant::TABLE_USER)
                    ->innerJoin(Constant::TABLE_FB_USER)->using('('.Constant::USER_ID.')')
                    ->innerJoin(Constant::TABLE_AUTH)->using('('.Constant::TABLE_AUTH_ID.')');
        if($by != NULL){
            $query->where($by);
            return $query->fetch();
        }
        
        return $query->fetchAll();
    }
    /**
     * 
     * @param array $by where clause
     * @param array $values to change
     * @param \Model\Constant $table const table name
     * @return DibiResult
     */
    public function update(array $by, array $values, $table){
        return \dibi::update($table, $values)->where($by)->execute();
    }
}
