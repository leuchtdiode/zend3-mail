<?php
namespace Mail\Mail\Attachment;

use Exception;
use function file_exists;
use function file_get_contents;
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

		$path = $this->getPath($entity);

		return file_put_contents($path, $content) !== false;
	}

	/**
	 * @param Entity $entity
	 * @return string|null
	 */
	public function read(Entity $entity)
	{
		$path = $this->getPath($entity);

		if (!file_exists($path))
		{
			return null;
		}

		return file_get_contents($path);
	}

	/**
	 * @return string
	 */
	private function getDirectory()
	{
		return $this->config['mail']['attachment']['storeDirectory'] ?? null;
	}

	/**
	 * @throws Exception
	 */
	private function ensureDirectoryOrFail()
	{
		$directory = $this->getDirectory();

		if (!$directory || !file_exists($directory) || !is_writable($directory))
		{
			throw new Exception('Attachment store directory ' . $directory . ' does not exist or is not writable');
		}
	}

	/**
	 * @param Entity $entity
	 * @return string
	 */
	private function getPath(Entity $entity): string
	{
		return sprintf(
			'%s/%s.%s',
			$this->getDirectory(),
			$entity->getId(),
			$entity->getExtension()
		);
	}
}