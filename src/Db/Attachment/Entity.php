<?php
namespace Mail\Db\Attachment;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use Mail\Db\MailEntity;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="mail_attachments")
 * @ORM\Entity(repositoryClass="Mail\Db\Attachment\Repository")
 */
class Entity
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
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string")
	 */
	private $extension;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string")
	 */
	private $mimeType;

	/**
	 * @var MailEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Mail\Db\MailEntity", inversedBy="attachments", cascade={"persist"})
	 * @ORM\JoinColumn(name="mailId", referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 **/
	private $mail;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id = Uuid::uuid4();
	}

	/**
	 * @return UuidInterface
	 */
	public function getId(): UuidInterface
	{
		return $this->id;
	}

	/**
	 * @param UuidInterface $id
	 */
	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getExtension(): string
	{
		return $this->extension;
	}

	/**
	 * @param string $extension
	 */
	public function setExtension(string $extension): void
	{
		$this->extension = $extension;
	}

	/**
	 * @return string
	 */
	public function getMimeType(): string
	{
		return $this->mimeType;
	}

	/**
	 * @param string $mimeType
	 */
	public function setMimeType(string $mimeType): void
	{
		$this->mimeType = $mimeType;
	}

	/**
	 * @return MailEntity
	 */
	public function getMail(): MailEntity
	{
		return $this->mail;
	}

	/**
	 * @param MailEntity $mail
	 */
	public function setMail(MailEntity $mail): void
	{
		$this->mail = $mail;
	}
}