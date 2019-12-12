<?php
namespace Mail\Mail;

class Mail
{
	/**
	 * @var Recipient[]
	 */
	private $to = [];

	/**
	 * @var Recipient[]
	 */
	private $cc = [];

	/**
	 * @var Recipient[]
	 */
	private $bcc = [];

	/**
	 * @var Recipient
	 */
	private $from;

	/**
	 * @var Recipient|null
	 */
	private $replyTo;

	/**
	 * @var string
	 */
	private $subject;

	/**
	 * @var string
	 */
	private $layoutTemplate;

	/**
	 * @var string
	 */
	private $contentTemplate;

	/**
	 * @var PlaceholderValues|null
	 */
	private $placeholderValues;

	/**
	 * @var Attachment[]
	 */
	private $attachments = [];

	/**
	 * @param Recipient $recipient
	 */
	public function addTo(Recipient $recipient)
	{
		$this->to[] = $recipient;
	}

	/**
	 * @param Recipient $recipient
	 */
	public function addCc(Recipient $recipient)
	{
		$this->cc[] = $recipient;
	}

	/**
	 * @param Recipient $recipient
	 */
	public function addBcc(Recipient $recipient)
	{
		$this->bcc[] = $recipient;
	}

	/**
	 * @param Attachment $attachment
	 */
	public function addAttachment(Attachment $attachment)
	{
		$this->attachments[] = $attachment;
	}

	/**
	 * @param Recipient[] $to
	 */
	public function setTo(array $to)
	{
		$this->to = $to;
	}

	/**
	 * @param Recipient[] $cc
	 */
	public function setCc(array $cc)
	{
		$this->cc = $cc;
	}

	/**
	 * @param Recipient[] $bcc
	 */
	public function setBcc(array $bcc)
	{
		$this->bcc = $bcc;
	}

	/**
	 * @param Recipient $from
	 */
	public function setFrom(Recipient $from)
	{
		$this->from = $from;
	}

	/**
	 * @param Recipient|null $replyTo
	 */
	public function setReplyTo(?Recipient $replyTo)
	{
		$this->replyTo = $replyTo;
	}

	/**
	 * @param string $subject
	 */
	public function setSubject(string $subject)
	{
		$this->subject = $subject;
	}

	/**
	 * @param string $layoutTemplate
	 */
	public function setLayoutTemplate(string $layoutTemplate)
	{
		$this->layoutTemplate = $layoutTemplate;
	}

	/**
	 * @param string $contentTemplate
	 */
	public function setContentTemplate(string $contentTemplate)
	{
		$this->contentTemplate = $contentTemplate;
	}

	/**
	 * @return Recipient[]
	 */
	public function getTo(): array
	{
		return $this->to;
	}

	/**
	 * @return Recipient[]
	 */
	public function getCc(): array
	{
		return $this->cc;
	}

	/**
	 * @return Recipient[]
	 */
	public function getBcc(): array
	{
		return $this->bcc;
	}

	/**
	 * @return Recipient
	 */
	public function getFrom(): Recipient
	{
		return $this->from;
	}

	/**
	 * @return Recipient|null
	 */
	public function getReplyTo(): ?Recipient
	{
		return $this->replyTo;
	}

	/**
	 * @return string
	 */
	public function getSubject(): string
	{
		return $this->subject;
	}

	/**
	 * @return string
	 */
	public function getLayoutTemplate(): string
	{
		return $this->layoutTemplate;
	}

	/**
	 * @return string
	 */
	public function getContentTemplate(): string
	{
		return $this->contentTemplate;
	}

	/**
	 * @return PlaceholderValues|null
	 */
	public function getPlaceholderValues()
	{
		return $this->placeholderValues;
	}

	/**
	 * @param PlaceholderValues|null $placeholderValues
	 */
	public function setPlaceholderValues($placeholderValues)
	{
		$this->placeholderValues = $placeholderValues;
	}

	/**
	 * @return Attachment[]
	 */
	public function getAttachments(): array
	{
		return $this->attachments;
	}

	/**
	 * @param Attachment[] $attachments
	 */
	public function setAttachments(array $attachments): void
	{
		$this->attachments = $attachments;
	}
}