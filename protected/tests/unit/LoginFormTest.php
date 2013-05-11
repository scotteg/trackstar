<?php
class LoginFormTest extends CTestCase
{
    public function testUserNameRequired()
    {
        $form = new LoginForm();
        $form->username = '';
        $form->password = 'password';
        $form->rememberMe = true;
        $this->assertFalse($form->validate());
        $form->username = 'admin';
        $this->assertTrue($form->validate());
    }
}