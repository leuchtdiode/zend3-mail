<?php
namespace Mail\Db\MailEntity\Filter;

use Common\Db\Filter;
use Doctrine\ORM\QueryBuilder;

class Sent implements Filter
{
	const DB_COLUMN = 't.sentAt';

	/**
	 * @var bool
	 */
	private $sent;

	/**
	 * @param bool $sent
	 */
	private function __construct($sent)
	{
		$this->sent = $sent;
	}

	/**
	 * @return Sent
	 */
	public static function yes()
	{
		return new self(true);
	}

	/**
	 * @return Sent
	 */
	public static function no()
	{
		return new self(false);
	}

	public function addClause(QueryBuilder $queryBuilder)
	{
		if ($this->sent)
		{
			$queryBuilder->andWhere(
				$queryBuilder->expr()->isNotNull(self::DB_COLUMN)
			);
		}
		else
		{
			$queryBuilder->andWhere(
				$queryBuilder->expr()->isNull(self::DB_COLUMN)
			);
		}
	}
}