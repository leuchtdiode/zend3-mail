<?php
namespace Mail\Action\Queue;

use Mail\Action\BaseConsoleAction;
use Mail\Queue\UnsentMailsSender;

class Send extends BaseConsoleAction
{
	/**
	 * @var UnsentMailsSender
	 */
	private $unsentMailsSender;

	/**
	 * @param UnsentMailsSender $unsentMailsSender
	 */
	public function __construct(UnsentMailsSender $unsentMailsSender)
	{
		$this->unsentMailsSender = $unsentMailsSender;
	}

	public function executeAction()
	{
		$this->unsentMailsSender->send();
	}
}