<?php

    namespace console\controllers;

    use Yii;
    use yii\console\Controller;
	use yii\console\ExitCode;

    class ConsoleController extends Controller
    {
		private $lockFile='';
		
        protected function lockProcess($pid)
        {
            $this->lockFile = realpath(dirname(__FILE__).'/../../').'/console/runtime/logs/'.md5($pid) . '.lock';

            if (file_exists($this->lockFile))
			{
				echo date('d.m.Y H:i:s').' - Already Running'.PHP_EOL;
				exit;
			}
			file_put_contents($this->lockFile,time());
        }

        protected function unlockProcess()
        {
            if (file_exists($this->lockFile))
			{
				unlink($this->lockFile);
			}
        }
		
		public function beforeAction($action)
		{
			if (!parent::beforeAction($action)) 
			{
				return false;
			}

			$this->lockProcess($this->id.$this->action->id);
			return true;
		}
		
		public function afterAction($action, $result)
		{
			$result = parent::afterAction($action, $result);
			$this->unlockProcess();
			return $result;
		}
    }