<?php
namespace Mail\Db;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="mail_mails")
 * @ORM\Entity(repositoryClass="Mail\Db\MailEntityRepository")
 */
class MailEntity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid");
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $subject;

	/**
	 * @ORM\Column(type="text")
	 */
	private $body;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $sentAt;

	/**
	 * @ORM\Column(type="string")
	 */
	private $error;

	/**
	 * @ORM\OneToMany(targetEntity="Mail\Db\RecipientEntity", mappedBy="mail", cascade={"all"}, orphanRemoval=true)
	 **/
	private $recipients;

	/**
	 * @ORM\OneToOne(targetEntity="Mail\Db\FromEntity", mappedBy="mail", cascade={"all"}, orphanRemoval=true)
	 **/
	private $from;

	/**
	 */
	public function __construct()
	{
		$this->id 			= Uuid::uuid4();
		$this->createdAt 	= new DateTime();
		$this->recipients 	= new ArrayCollection();
	}

	/**
	 * @return UuidInterface
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param UuidInterface $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * @param string $subject
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	/**
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param string $body
	 */
	public function setBody($body)
	{
		$this->body = $body;
	}

	/**
	 * @return DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @param DateTime $createdAt
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
	}

	/**
	 * @return DateTime|null
	 */
	public function getSentAt()
	{
		return $this->sentAt;
	}

	/**
	 * @param DateTime $sentAt
	 */
	public function setSentAt($sentAt)
	{
		$this->sentAt = $sentAt;
	}

	/**
	 * @return string|null
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * @param string $error
	 */
	public function setError($error)
	{
		$this->error = $error;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getRecipients()
	{
		return $this->recipients;
	}

	/**
	 * @param ArrayCollection $recipients
	 */
	public function setRecipients($recipients)
	{
		$this->recipients = $recipients;
	}

	/**
	 * @return FromEntity
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * @param FromEntity $from
	 */
	public function setFrom($from)
	{
		$this->from = $from;
	}
}