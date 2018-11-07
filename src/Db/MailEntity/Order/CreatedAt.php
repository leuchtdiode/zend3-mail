<?php
namespace Mail\Db\MailEntity\Order;

use Common\Db\Order;
use Doctrine\ORM\QueryBuilder;

class CreatedAt implements Order
{
	const DB_COLUMN = 't.createdAt';

	/**
	 * @var string
	 */
	private $direction;

	/**
	 * @param string $direction
	 */
	private function __construct($direction)
	{
		$this->direction = $direction;
	}

	/**
	 * @return CreatedAt
	 */
	public static function asc()
	{
		return new self('ASC');
	}

	/**
	 * @return CreatedAt
	 */
	public static function desc()
	{
		return new self('DESC');
	}

	public function addOrder(QueryBuilder $queryBuilder)
	{
		$queryBuilder->addOrderBy(self::DB_COLUMN, $this->direction);
	}
}