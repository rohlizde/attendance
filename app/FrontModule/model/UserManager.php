<?php

namespace Model;

use Nette,
    Nette\Utils\Strings;

/**
 * Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator {

    const
            AUTH_TABLE = 'auth',
            AUTH_NAME = 'Uživatel',
            TABLE_NAME = 'user',
            COLUMN_ID = 'user_id',
            COLUMN_NAME = 'email',
            COLUMN_PASSWORD = 'password',
            COLUMN_ROLE = 'auth_id',
            PASSWORD_MAX_LENGTH = 4096;


    /** @var UserModel */
    private $userModel;

    public function __construct(UserModel $userModel)
    {
            $this->userModel = $userModel;
    }

    /**
     * Performs an authentication
     * @param array
     * @return \Nette\Security\Identity
     * @throws \Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
            list($mail, $password) = $credentials;
            $user = $this->userModel->findUser(array('email' => $mail));

            if (!$user) {
                    throw new AuthenticationException("User '$mail' not found.", self::IDENTITY_NOT_FOUND);
            }

            if ($user->password !== sha1($password)) {
                    throw new AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
            }

            return $this->userModel->createIdentity($user);
    }

    /**
     * Performs an authentication.
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
//    public function authenticate(array $credentials) {
//        list($email, $password) = $credentials;
//        $row = \dibi::select('*')
//                ->from(self::TABLE_NAME)
//                ->where(self::COLUMN_NAME.' = %s',$email)
//                ->fetchAll();
//        if (!$row) {
//            throw new Nette\Security\AuthenticationException('Špatně zadaný email.', self::IDENTITY_NOT_FOUND);
//        } elseif (!self::verifyPassword($password, $row[0][self::COLUMN_PASSWORD])) {
//            throw new Nette\Security\AuthenticationException('Špatně zadané heslo.', self::INVALID_CREDENTIAL);
//        }
//        $arr = $row[0]->toArray();
//        unset($arr[self::COLUMN_PASSWORD]);
//        return new Nette\Security\Identity($row[0][self::COLUMN_ID], $row[0][self::COLUMN_ROLE], $arr);
//    }
//    public function authenticateFacebook(Array $facebook){
//        $facebook = current($facebook);
//        $row = \dibi::select('*')
//                ->from(self::TABLE_NAME)
//                ->where(self::COLUMN_NAME.' = %s', $facebook['email'])
//                ->fetchAll();
//        if (!$row) {
//            $this->createUserViaFacebook($facebook);
//        }
//        $row = \dibi::select('*')
//                ->from(self::TABLE_NAME)
//                ->where(self::COLUMN_NAME.' = %s',$facebook['email'])
//                ->fetchAll();
//        $arr = $row[0]->toArray();
//        unset($arr[self::COLUMN_PASSWORD]);
//        return new Nette\Security\Identity($row[0][self::COLUMN_ID], $row[0][self::COLUMN_ROLE], $arr);
//    }
//    public function createUserViaFacebook(Array $facebook){
//        $auth = \dibi::select('*')
//                ->from(self::AUTH_TABLE)
//                ->where('name = %s', self::AUTH_NAME)
//                ->fetchSingle();
//        if(!$auth){
//            throw new Exception('Neexistuje ' . self::AUTH_NAME);
//        }
//        $insertArray = $this->createInsertArray($facebook, $auth);
//        \dibi::insert(self::TABLE_NAME, $insertArray)->execute();
//        
//    }
//    
//    private function createInsertArray(Array $facebook, $auth_id){
//        $array = array(
//            'auth_id' => $auth_id,
//            'name' => $facebook['first_name'],
//            'surname' => $facebook['last_name'],
//            'email' => $facebook['email'],
//            'password' => ''
//        );
//        return $array;
//    }
//    
//    /**
//     * Computes salted password hash.
//     * @param  string
//     * @return string
//     */
//    public static function hashPassword($password, $options = NULL) {
//        return sha1($password);
//    }
//
//    /**
//     * Verifies that a password matches a hash.
//     * @return bool
//     */
//    public static function verifyPassword($password, $hash) {
//        return (self::hashPassword($password) == $hash);
//    }

}
