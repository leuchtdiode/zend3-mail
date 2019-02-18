<?php
namespace MailTest\Queue;

use DateTime;
use Mail\Db\MailEntityRepository;
use Mail\Db\RecipientEntity;
use Mail\Mail\Mail;
use Mail\Mail\Recipient;
use Mail\Queue\Queue;
use Testing\BaseTestCase;

class QueueTest extends BaseTestCase
{
	/**
	 * @var Queue
	 */
	private $queue;

	/**
	 * @throws \Doctrine\ORM\Tools\ToolsException
	 */
	public function setUp()
	{
		parent::setUp();

		$this->queue = $this->getInstance(Queue::class);
	}

	public function test_me()
	{
		$mail = new Mail();
		$mail->setSubject('test betreff');
		$mail->setCc(
			[
				Recipient::create('cc-recipient1@anything.com', 'CC-Empfänger1'),
				Recipient::create('cc-recipient2@anything.com', 'CC-Empfänger2')
			]
		);
		$mail->setBcc(
			[
				Recipient::create('bcc-recipient1@anything.com', 'BCC-Empfänger1'),
				Recipient::create('bcc-recipient2@anything.com', 'BCC-Empfänger2'),
			]
		);
		$mail->setTo(
			[
				Recipient::create('recipient@anything.com', 'Empfänger')
			]
		);
		$mail->setFrom(
			Recipient::create('from@anything.com', 'Absender')
		);
		$mail->setLayoutTemplate('testing/mail/test-layout');
		$mail->setContentTemplate('testing/mail/test-template');

		$this->queue->add($mail);

		$entities = $this
			->getInstance(MailEntityRepository::class)
			->findAll();

		$this->assertCount(1, $entities);

		$entity = reset($entities);

		$this->assertNotEmpty($entity->getId());
		$this->assertEquals((new DateTime())->format('Y-m-d'), $entity->getCreatedAt()->format('Y-m-d'));
		$this->assertEquals('test betreff', $entity->getSubject());
		$this->assertEquals($this->getExpectedBody(), $entity->getBody());

		$from = $entity->getFrom();

		$this->assertEquals('from@anything.com', $from->getEmail());
		$this->assertEquals('Absender', $from->getName());

		$recipients = $entity->getRecipients();

		$this->assertCount(5, $recipients);

		$this->assertEquals('recipient@anything.com', $recipients[0]->getEmail());
		$this->assertEquals('Empfänger', $recipients[0]->getName());
		$this->assertEquals(RecipientEntity::TYPE_TO, $recipients[0]->getType());

		$this->assertEquals('cc-recipient1@anything.com', $recipients[1]->getEmail());
		$this->assertEquals('CC-Empfänger1', $recipients[1]->getName());
		$this->assertEquals(RecipientEntity::TYPE_CC, $recipients[1]->getType());

		$this->assertEquals('cc-recipient2@anything.com', $recipients[2]->getEmail());
		$this->assertEquals('CC-Empfänger2', $recipients[2]->getName());
		$this->assertEquals(RecipientEntity::TYPE_CC, $recipients[2]->getType());

		$this->assertEquals('bcc-recipient1@anything.com', $recipients[3]->getEmail());
		$this->assertEquals('BCC-Empfänger1', $recipients[3]->getName());
		$this->assertEquals(RecipientEntity::TYPE_BCC, $recipients[3]->getType());

		$this->assertEquals('bcc-recipient2@anything.com', $recipients[4]->getEmail());
		$this->assertEquals('BCC-Empfänger2', $recipients[4]->getName());
		$this->assertEquals(RecipientEntity::TYPE_BCC, $recipients[4]->getType());
	}

	/**
	 * @return string
	 */
	private function getExpectedBody()
	{
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		body {
			font-family: Arial;
			font-size: 14px;
		}
	</style>
</head>
<body yahoo bgcolor="#fff">
<table width="100%" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0; min-width: 100%!important; font-family: Arial; font-size: 14px">
	<tr>
		<td>
			<table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 600px;">
				<tr>
					<td style="padding: 30px 15px 20px 15px;" colspan="2">
						<p>
	ich bin ein test content mit einem <a href="#">link</a>
</p>					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>';
	}
}