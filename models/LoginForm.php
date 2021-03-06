<?php

/** User: MoAdel ...*/

namespace app\models;

use app\core\Model;
use app\core\Application;
use app\core\DbModel;

/**
 * Class LoginForm
 * 
 * @author Mohamed-Adel-work <mohamed.wemail@gmail.com>
 * @package app\models
 * 
 */

class LoginForm extends Model
{
    public $email = '';
    public $password = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Your email',
            'password' => 'Password',
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'User does not exist with this email address');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        
        // echo '<pre>';
        // var_dump($user);
        // echo '</pre>';
        // exit;
        
        return Application::$app->login($user);
    }    
}
