<?php
namespace Mail\Mail;

use DateTime;
use Exception;
use Mail\Db\MailEntity;
use Mail\Db\MailEntitySaver;
use Mail\Db\RecipientEntity;
use Mail\Mail\Attachment\FileSystemHandler;
use Zend\Mail\AddressList;
use Zend\Mail\Message as MailMessage;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Mime;
use Zend\Mime\Part;

class Sender
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var MailEntitySaver
	 */
	private $saver;

	/**
	 * @var FileSystemHandler
	 */
	private $attachmentFileSystemHandler;

	/**
	 * @var AddressList
	 */
	private $to;

	/**
	 * @var AddressList
	 */
	private $cc;

	/**
	 * @var AddressList
	 */
	private $bcc;

	/**
	 * @var array
	 */
	private $mailConfig;

	/**
	 * @param array $config
	 * @param MailEntitySaver $saver
	 * @param FileSystemHandler $attachmentFileSystemHandler
	 */
	public function __construct(array $config, MailEntitySaver $saver, FileSystemHandler $attachmentFileSystemHandler)
	{
		$this->config                      = $config;
		$this->saver                       = $saver;
		$this->attachmentFileSystemHandler = $attachmentFileSystemHandler;
	}

	/**
	 * @param MailEntity $mailEntity
	 * @return bool
	 * @throws Exception
	 */
	public function send(MailEntity $mailEntity)
	{
		$this->mailConfig = $this->config['mail'];

		try
		{
			$options = new SmtpOptions($this->mailConfig['smtp']);

			$transport = new Smtp($options);

			$text          = new Part($mailEntity->getBody());
			$text->type    = Mime::TYPE_HTML;
			$text->charset = 'utf-8';

			$mailParts = [
				$text,
			];

			$from = $mailEntity->getFrom();

			$message = new MailMessage();
			$message->setEncoding('UTF-8');
			$message->setSubject(
				$this->isDebugEnabled()
					? 'DEBUG: ' . $mailEntity->getSubject()
					: $mailEntity->getSubject()
			);
			$message->setFrom(
				$from->getEmail(),
				$from->getName()
			);
			$message->setReplyTo($from->getEmail());

			$this->loadRecipients($mailEntity);

			$message->setTo($this->to);
			$message->setCc($this->cc);
			$message->setBcc($this->bcc);

			foreach ($mailEntity->getAttachments() as $attachmentEntity)
			{
				$content = $this->attachmentFileSystemHandler->read($attachmentEntity);

				if (!$content)
				{
					continue;
				}

				$attachment = new Part($content);
				$attachment->setType(
					$attachmentEntity->getMimeType()
				);
				$attachment->setFileName(
					utf8_decode($attachmentEntity->getName() . '.' . $attachmentEntity->getExtension())
				);
				$attachment->setDisposition(Mime::DISPOSITION_ATTACHMENT);
				$attachment->setEncoding(Mime::ENCODING_BASE64);
				$attachment->setCharset('UTF-8');
				$attachment->setId($attachmentEntity->getId()->toString());

				$mailParts[] = $attachment;
			}

			$mimeMessage = new MimeMessage();
			$mimeMessage->setParts($mailParts);

			$message->setBody($mimeMessage);

			$transport->send($message);

			$mailEntity->setSentAt(new DateTime());

			$this->saver->save($mailEntity);

			return true;
		}
		catch (Exception $ex)
		{
			$mailEntity->setError($ex->getMessage());
		}

		return false;
	}

	/**
	 * @param MailEntity $mailEntity
	 */
	private function loadRecipients(MailEntity $mailEntity)
	{
		$this->to  = new AddressList();
		$this->cc  = new AddressList();
		$this->bcc = new AddressList();

		if ($this->isDebugEnabled())
		{
			$this->to->add(
				$this->mailConfig['debug']['email']
			);

			return;
		}

		foreach ($mailEntity->getRecipients() as $recipient)
		{
			switch ($recipient->getType())
			{
				case RecipientEntity::TYPE_TO:
					$this->to->add($recipient->getEmail(), $recipient->getName());
					break;

				case RecipientEntity::TYPE_CC:
					$this->cc->add($recipient->getEmail(), $recipient->getName());
					break;

				case RecipientEntity::TYPE_BCC:
					$this->bcc->add($recipient->getEmail(), $recipient->getName());
					break;
			}
		}
	}

	/**
	 * @return bool
	 */
	private function isDebugEnabled()
	{
		return $this->mailConfig['debug']['enabled'] ?? false;
	}
}