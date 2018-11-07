<?php
namespace Mail\Queue;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Mail\Db\MailEntity\Filter\Sent;
use Mail\Db\MailEntity\Order\CreatedAt;
use Mail\Mail\Sender as MailSender;
use Mail\Db\MailEntityRepository;

class UnsentMailsSender
{
	/**
	 * @var MailEntityRepository
	 */
	private $repository;

	/**
	 * @var MailSender
	 */
	private $mailSender;

	/**
	 * @param MailEntityRepository $repository
	 * @param MailSender $mailSender
	 */
	public function __construct(
		MailEntityRepository $repository,
		MailSender $mailSender
	)
	{
		$this->repository = $repository;
		$this->mailSender = $mailSender;
	}

	public function send()
	{
		$mails = $this->repository->filter(
			FilterChain::create()
				->addFilter(Sent::no()),
			OrderChain::create()
				->addOrder(CreatedAt::desc())
		);

		foreach ($mails as $mail)
		{
			$this->mailSender->send($mail);
		}
	}
}