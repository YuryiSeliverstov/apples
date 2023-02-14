<?php


namespace console\controllers;

use common\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;


class UsersController extends Controller
{
    public function actionAdd() 
	{
		$user = new User(['username'=>'user','email'=>'user@mail.com']);
		$userPassword='123123';
		$user->setPassword($userPassword);
		$user->status = User::STATUS_ACTIVE;
		$user->generateAuthKey();
        $user->generateEmailVerificationToken();
		if (!$user->save()) 
		{
			print_r($user->errors);
		} 
		echo 'User Created with username='.$user->username.' and password='.$userPassword.PHP_EOL;
		echo 'done';
        return ExitCode::OK;
    }
}