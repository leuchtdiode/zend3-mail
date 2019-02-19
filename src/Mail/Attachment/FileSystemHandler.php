<?php
namespace Mail\Mail\Attachment;

use Exception;
use Mail\Db\Attachment\Entity;

class FileSystemHandler
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @param Entity $entity
	 * @param string $content
	 * @return bool
	 * @throws Exception
	 */
	public function write(Entity $entity, string $content)
	{
		$this->ensureDirectoryOrFail();

		$path = sprintf(
			'%s/%s.%s',
			$this->getDirectory(),
			$entity->getId(),
			$entity->getExtension()
		);

		return file_put_contents($path, $content) !== false;
	}

	/**
	 * @return string
	 */
	private function getDirectory()
	{
		return $this->config['mail']['attachment']['storeDirectory'];
	}

	/**
	 *
	 */
	private function ensureDirectoryOrFail()
	{
		$directory = $this->getDirectory();

		if (!file_exists($directory) || !is_writable($directory))
		{
			throw new Exception('Attachment store directory ' . $directory . ' does not exist or is not writable');
		}
	}
}