<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    
    public function authenticate()
    {
        $user = User::model()->find('LOWER(username)=?', array(strtolower($this->username)));
        
        if ($user===NULL) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else { // Valid login
            $this->_id = $user->id; // parent returns username for getId, so set _id to user.id and override getId() to return _id
            $this->username = $user->username;
            $this->setState('lastLogin', date('m/d/y g:i A', strtotime($user->last_login_time)));
            $user->saveAttributes(array(
                'last_login_time'=>date('Y-m-d H:i:s', time()),
            ));
            $this->errorCode = self::ERROR_NONE;
        }
        
        return $this->errorCode==self::ERROR_NONE;
    }
    
    public function getId() // Override parent's getId which returns username for getId()
    {
        return $this->_id;
    }
}