<?php
namespace Mail\Db;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="mail_recipients")
 * @ORM\Entity(repositoryClass="Mail\Db\RecipientEntityRepository")
 */
class RecipientEntity
{
	const TYPE_TO 	= 1;
	const TYPE_CC	= 2;
	const TYPE_BCC	= 3;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid");
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $email;

	/**
	 * @ORM\Column(type="string")
	 */
	private $name;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $type;

	/**
	 * @ORM\ManyToOne(targetEntity="Mail\Db\MailEntity", inversedBy="recipients", cascade={"persist"})
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
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type)
	{
		$this->type = $type;
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