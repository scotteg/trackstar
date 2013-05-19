<?php
return array(
    'title'=>'Please fill out the following form with your login credentials<br>',
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
            'layout'=>"{input} {label}",
        ),
        '<p class="note">Fields with <span class="required">*</span> are required</p>',
    ),
    'buttons'=>array(
        '',array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
);