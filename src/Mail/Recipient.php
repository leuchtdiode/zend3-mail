<?php
namespace Mail\Mail;

class Recipient
{
	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string|null
	 */
	private $name;

	/**
	 * @param string $email
	 * @param null|string $name
	 */
	private function __construct(
		$email,
		$name = null
	)
	{
		$this->email = $email;
		$this->name = $name;
	}

	/**
	 * @param string $email
	 * @param string|null $name
	 * @return Recipient
	 */
	public static function create($email, $name = null)
	{
		return new self($email, $name);
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email)
	{
		$this->email = $email;
	}

	/**
	 * @return null|string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param null|string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
}