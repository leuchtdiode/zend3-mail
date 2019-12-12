<?php
namespace Mail\Db;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="mail_reply_to")
 */
class ReplyToEntity
{
	/**
	 * @var UuidInterface
	 *
	 * @ORM\Id
	 * @ORM\Column(type="uuid");
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string")
	 */
	private $email;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $name;

	/**
	 * @var MailEntity
	 *
	 * @ORM\OneToOne(targetEntity="Mail\Db\MailEntity", inversedBy="replyTo", cascade={"persist"})
	 * @ORM\JoinColumn(name="mailId", referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 **/
	private $mail;

	/**
	 */
	public function __construct()
	{
		$this->id = Uuid::uuid4();
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
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @return string|null
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string|null $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return MailEntity
	 */
	public function getMail()
	{
		return $this->mail;
	}

	/**
	 * @param MailEntity $mail
	 */
	public function setMail($mail)
	{
		$this->mail = $mail;
	}
}