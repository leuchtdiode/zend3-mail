<?php
namespace Mail\Mail;

class Attachment
{
	/**
	 * @var string
	 */
	private $fileName;

	/**
	 * @var string
	 */
	private $mimeType;

	/**
	 * @var string
	 */
	private $content;

	/**
	 * @return Attachment
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return string
	 */
	public function getFileName(): string
	{
		return $this->fileName;
	}

	/**
	 * @param string $fileName
	 * @return Attachment
	 */
	public function setFileName(string $fileName): Attachment
	{
		$this->fileName = $fileName;
		return $this;
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
	 * @return Attachment
	 */
	public function setMimeType(string $mimeType): Attachment
	{
		$this->mimeType = $mimeType;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->content;
	}

	/**
	 * @param string $content
	 * @return Attachment
	 */
	public function setContent(string $content): Attachment
	{
		$this->content = $content;
		return $this;
	}
}