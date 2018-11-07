<?php
namespace Mail\Action;

use Zend\Mvc\Console\Controller\AbstractConsoleController;

abstract class BaseConsoleAction extends AbstractConsoleController
{
	abstract public function executeAction();
}