<?php

namespace Model;

use Nette\Utils\Strings;

class FacebookAuthenticator extends \Nette\Object implements \Nette\Security\IAuthenticator {

    /** @var UserModel */
    private $userModel;
    private $fbPool = array(
        "user_id",
        "fbid",
        "first_name",
        "last_name",
        "gender",
        "link",
        "username",
        "timezone",
        "locale"
    );

    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }

    /**
     * @param array $fbUser
     * @return \Nette\Security\Identity
     */
    public function authenticate(array $fbUser) {
        $by = array(Constant::USER_EMAIL => $fbUser['email']);
        $user = $this->userModel->getUser($by);

        if ($user) {
            $this->updateFacebookData($user, $fbUser);
        } else {
            $this->register($fbUser);
        }
        //dd($user,'IsUserTest');
        $fullUser = $this->userModel->getFullUser($by);
        //dd($fullUser,'Fulluser');
        return $this->userModel->createIdentity($fullUser);
    }

    public function register(array $me) {
        return $this->userModel->registerUser(array(
                    Constant::USER_EMAIL => $me['email'],
                    Constant::TABLE_AUTH_ID => Constant::PUSER,
                    Constant::USER_USERNAME => $this->createUsername($me['first_name'] . " " . $me['last_name']),
                    Constant::USER_ACTIVE => TRUE
        ));
        //todo Rohlajz temporary solution
    }

    /**
     * 
     * @param \DibiRow $user
     * @param array $me
     */
    public function updateFacebookData(\DibiRow $user, array $me) {
        dd($user, "nette user");
        $data = $this->fillFbArray($me);
        $fbuser = $this->userModel->getFbUser(array(Constant::USER_ID => $user->user_id));
        //ma FB zaznam v DB
        if ($fbuser == NULL) {
            $data['fbid'] = $me['id']; //special occasion
            $data['user_id'] = $user->user_id; //explicit set
            $this->userModel->insertFbUser($data);

            dd($data, 'Data');
            //todo insert data
        } else {
            //todo update data
            $this->userModel->updateFbUser($data, array(Constant::USER_ID => $user->user_id));
            dd($data, 'Datad');
        }
        if (empty($user->permuser)) {
            //$this->userModel->update(array(Constant::USER_ID => $user->user_id), array(Constant::USER_USERNAME => $this->createUsername($user->first_name. " " .$user->last_name)), Constant::TABLE_USER);
            //todo Rohlajz FIX DUPLICITy user->name
        }
    }

    /**
     * 
     * @param array $values facebook data
     */
    private function fillFbArray($values) {
        $updateData = array();
        foreach ($this->fbPool as $index) {
            if (isset($values[$index])) {
                $updateData[$index] = $values[$index];
            }
        }
        return $updateData;
    }

    private function createUsername($name) {
        $username = strtolower(Strings::toAscii($name));
        $username = Str_Replace(Array(" "), ".", $username); //nahradí mezery pomlčkami
        return $username;
    }

}
