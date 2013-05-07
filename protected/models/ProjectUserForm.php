<?php

class ProjectUserForm extends CFormModel
{
    public $username;
    public $role;
    public $project;
    private $_user;

    public function rules()
    {
        return array(
            array('username, role', 'required'),
            array('username', 'exist', 'className'=>'User'),
            array('username', 'verify') // verify is a validator
        );
    }

    /**
     * Verifies existence of user and creates association between user, role, and project
     */
    public function verify()
    {
        if (!$this->hasErrors()) { // Verify only if no other input errors exist

            // Is this necessary, since we're already using the exist rule? And if not,
            // do we even need this validator (which is doing more than a validator should anyway)?
            $user = User::model()->findByAttributes(array('username'=>$this->username));

            if ($user && !$this->project->isUserInProject($user)) {
                $this->_user = $user;
            } else {
                $this->addError('username', 'This user has already been added to the project');
            }
        }
    }

    public function assign()
    {
        if ($this->_user instanceof User) {
            $this->project->assignUser($this->_user->id, $this->role);

            $bizRule = 'return isset($params["project"]) && $params["project"]->allowCurrentUser("'.$this->role.'");';
            Yii::app()->authManager->assign($this->role, $this->_user->id, $bizRule);
            return true;
        } else {
            $this->addError('username', 'Error when attempting to assign this user to the project');
            return false;
        }
    }

    /**
     * Create array of existing usernames for CJuiAutoComplete
     * @return array array of existing usernames
     */
    public function createUsernameList()
    {
        $sql = 'SELECT username FROM tbl_user';
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $usernames = array();

        foreach ($rows as $row) {
            $usernames[] = $row['username'];
        }

        return $usernames;
    }
}