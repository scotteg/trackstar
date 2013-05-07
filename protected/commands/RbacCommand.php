<?php
class RbacCommand extends CConsoleCommand
{
    private $_authManager;

    public function getHelp()
    {
        $description = "DESCRIPTION\n";
        $description .= "    This command generates an initial RBAC authorization hierarchy.\n";

        return parent::getHelp() . $description;
    }

    public function actionIndex()
    {
        $this->ensureAuthManagerDefined();

        // Confirm action
        $message = "This command will create three roles: Owner, Member, and Reader, and the following permissions:\n";
        $message .= "create, read, update, delete user\n";
        $message .= "create, read, update, delete project\n";
        $message .= "create, read, update, delete issue\n";
        $message .= 'Would you like to continue?';

        if ($this->confirm($message)) {
            // First remove all operations, roles, child relationships, and assignments
            $this->_authManager->clearAll();

            // Create the lowest level operations for users
            $this->_authManager->createOperation('createUser', 'Create a new user'); // Should be addUser
            $this->_authManager->createOperation('readUser', 'Read user profile information');
            $this->_authManager->createOperation('updateUser', 'Update a user\'s information');
            $this->_authManager->createOperation('deleteUser', 'Remove a user from a project'); // Should be removeUser

            // Create the lowest level operations for projects
            $this->_authManager->createOperation('createProject', 'Create a new project');
            $this->_authManager->createOperation('readProject', 'Read project information');
            $this->_authManager->createOperation('updateProject', 'Update project information');
            $this->_authManager->createOperation('deleteProject', 'Delete a project');

            // Create the lowest level operations for issues
            $this->_authManager->createOperation('createIssue', 'Create a new issue');
            $this->_authManager->createOperation('readIssue', 'Read issue information');
            $this->_authManager->createOperation('updateIssue', 'Update issue information');
            $this->_authManager->createOperation('deleteIssue', 'Delete an issue from a project');

             // Create the reader role and add permissions as children
            $role=$this->_authManager->createRole('reader');
            $role->addChild('readUser');
            $role->addChild('readProject');
            $role->addChild('readIssue');

            // Create the member role and add permissions including the reader role as children
            $role=$this->_authManager->createRole('member');
            $role->addChild('reader');
            $role->addChild('createIssue');
            $role->addChild('updateIssue');
            $role->addChild('deleteIssue');

            // Create the owner role and add the permissions including the reader and member roles as children
            $role=$this->_authManager->createRole('owner');
            $role->addChild('reader'); // Is this necessary since adding member also adds reader?
            $role->addChild('member');
            $role->addChild('createUser');
            $role->addChild('updateUser');
            $role->addChild('deleteUser');
            $role->addChild('createProject');
            $role->addChild('updateProject');
            $role->addChild('deleteProject');

            echo "Authorization hierarchy successfully generated.\n";
        } else {
            echo "Operation cancelled.\n";
        }
    }

    public function actionDelete()
    {
        $this->ensureAuthManagerDefined();
        $message = "This command will clear all RBAC definitions.\n";
        $message .= 'Would you like to continue?';

        if ($this->confirm($message)) {
            $this->_authManager->clearAll();
            echo "Authorization hierarchy removed.\n";
        } else {
            echo "Delete operation cancelled.\n";
        }
    }

    protected function ensureAuthManagerDefined()
    {
        if (($this->_authManager=Yii::app()->authManager)===null) {
            $message = 'Error: an authorization manager named \'authManager\' must be configured to use this command.';
            $this->usageError($message);
        }
    }
}
