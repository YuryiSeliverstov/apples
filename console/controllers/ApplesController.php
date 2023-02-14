<?php


namespace console\controllers;

use common\models\Apple;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;


class ApplesController extends Controller
{
    public function actionGenerate() 
	{
		$appleCreatedCount=0;
		Yii::$app->db->createCommand('TRUNCATE '.Apple::tableName())->execute();
		for ($i=0;$i<27;$i++)
		{
			$apple=new Apple();
			if ($apple->generate())
			{
				$appleCreatedCount++;
			}
		}
		echo 'Apples Created='.$appleCreatedCount.PHP_EOL;
        return ExitCode::OK;
    }
}