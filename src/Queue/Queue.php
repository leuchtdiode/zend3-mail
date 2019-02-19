<?php
namespace Mail\Queue;

use Exception;
use Doctrine\Common\Collections\ArrayCollection;
use Mail\Db\Attachment\Entity as AttachmentEntity;
use Mail\Db\FromEntity;
use Mail\Db\MailEntity;
use Mail\Db\MailEntitySaver;
use Mail\Db\RecipientEntity;
use Mail\Mail\Attachment\FileSystemHandler;
use Mail\Mail\BodyCreator;
use Mail\Mail\Mail;
use Mail\Mail\Recipient;
use function pathinfo;
use const PATHINFO_FILENAME;

class Queue
{
	/**
	 * @var BodyCreator
	 */
	private $bodyCreator;

	/**
	 * @var MailEntitySaver
	 */
	private $saver;

	/**
	 * @var FileSystemHandler
	 */
	private $attachmentFileSystemHandler;

	/**
	 * @var Mail
	 */
	private $mail;

	/**
	 * @var MailEntity
	 */
	private $mailEntity;

	/**
	 * @var RecipientEntity[]
	 */
	private $recipients;

	/**
	 * @param BodyCreator $bodyCreator
	 * @param MailEntitySaver $saver
	 * @param FileSystemHandler $attachmentFileSystemHandler
	 */
	public function __construct(
		BodyCreator $bodyCreator,
		MailEntitySaver $saver,
		FileSystemHandler $attachmentFileSystemHandler
	)
	{
		$this->bodyCreator = $bodyCreator;
		$this->saver = $saver;
		$this->attachmentFileSystemHandler = $attachmentFileSystemHandler;
	}

	/**
	 * @param Mail $mail
	 * @return bool
	 * @throws Exception
	 */
	public function add(Mail $mail)
	{
		$this->mail = $mail;

		$body = $this->bodyCreator->forMail($mail);

		$this->mailEntity = new MailEntity();

		$this->makeRecipients();

		$this->mailEntity->setRecipients(
			new ArrayCollection($this->recipients)
		);
		$this->mailEntity->setFrom(
			$this->makeFrom()
		);
		$this->mailEntity->setSubject($mail->getSubject());
		$this->mailEntity->setBody($body);

		$this->makeAttachments();

		$this->saver->save($this->mailEntity);
	}

	/**
	 * @return FromEntity
	 */
	private function makeFrom()
	{
		$mailFrom = $this->mail->getFrom();

		$fromEntity = new FromEntity();
		$fromEntity->setEmail($mailFrom->getEmail());
		$fromEntity->setName($mailFrom->getName());
		$fromEntity->setMail($this->mailEntity);

		return $fromEntity;
	}

	/**
	 */
	private function makeRecipients()
	{
		$this->addRecipientsForType($this->mail->getTo(), RecipientEntity::TYPE_TO);
		$this->addRecipientsForType($this->mail->getCc(), RecipientEntity::TYPE_CC);
		$this->addRecipientsForType($this->mail->getBcc(), RecipientEntity::TYPE_BCC);
	}

	/**
	 * @param Recipient[] $recipients
	 * @param int $type
	 */
	private function addRecipientsForType($recipients, $type)
	{
		if (!$recipients)
		{
			return;
		}

		foreach ($recipients as $recipient)
		{
			$recipientEntity = new RecipientEntity();
			$recipientEntity->setEmail($recipient->getEmail());
			$recipientEntity->setName($recipient->getName());
			$recipientEntity->setType($type);
			$recipientEntity->setMail($this->mailEntity);

			$this->recipients[] = $recipientEntity;
		}
	}

	/**
	 * @throws Exception
	 */
	private function makeAttachments()
	{
		foreach ($this->mail->getAttachments() as $attachment)
		{
			$fileName = $attachment->getFileName();

			$attachmentEntity = new AttachmentEntity();
			$attachmentEntity->setMail($this->mailEntity);
			$attachmentEntity->setMimeType($attachment->getMimeType());
			$attachmentEntity->setName(
				pathinfo($fileName, PATHINFO_FILENAME)
			);
			$attachmentEntity->setExtension(
				pathinfo($fileName, PATHINFO_EXTENSION)
			);

			$this->mailEntity
				->getAttachments()
				->add($attachmentEntity);

			$this->attachmentFileSystemHandler->write($attachmentEntity, $attachment->getContent());
		}
	}
}