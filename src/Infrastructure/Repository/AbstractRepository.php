<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace AmeliaBooking\Infrastructure\Repository;

use AmeliaBooking\Domain\Collection\Collection;
use AmeliaBooking\Domain\Common\Exceptions\InvalidArgumentException;
use AmeliaBooking\Domain\Entity\Bookable\Service\Service;
use AmeliaBooking\Domain\Entity\Coupon\Coupon;
use AmeliaBooking\Domain\Entity\Location\Location;
use AmeliaBooking\Domain\Entity\Notification\Notification;
use AmeliaBooking\Domain\Entity\Payment\Payment;
use AmeliaBooking\Domain\Entity\User\AbstractUser;
use AmeliaBooking\Infrastructure\Common\Exceptions\NotFoundException;
use AmeliaBooking\Infrastructure\Common\Exceptions\QueryExecutionException;
use AmeliaBooking\Infrastructure\Connection;

/**
 * Class AbstractRepository
 *
 * @package AmeliaBooking\Infrastructure\Repository
 */
class AbstractRepository
{
    const FACTORY = '';

    /** @var \PDO */
    protected $connection;

    /** @var string */
    protected $table;

    /**
     * @param Connection $connection
     * @param string     $table
     */
    public function __construct(Connection $connection, $table)
    {
        $this->connection = $connection();
        $this->table = $table;
    }

    /**
     * @param int $id
     *
     * @return Payment|Coupon|Service|Notification|AbstractUser|Location
     * @throws NotFoundException
     * @throws QueryExecutionException
     */
    public function getById($id)
    {
        try {
            $statement = $this->connection->prepare($this->selectQuery() . " WHERE {$this->table}.id = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            $row = $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new QueryExecutionException('Unable to find by id in ' . __CLASS__, $e->getCode(), $e);
        }

        if (!$row) {
            throw new NotFoundException('Data not found in ' . __CLASS__);
        }

        return call_user_func([static::FACTORY, 'create'], $row);
    }

    /**
     * @return Collection
     * @throws InvalidArgumentException
     * @throws QueryExecutionException
     */
    public function getAll()
    {
        try {
            $statement = $this->connection->query($this->selectQuery());
            $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new QueryExecutionException('Unable to get data from ' . __CLASS__, $e->getCode(), $e);
        }

        $items = [];
        foreach ($rows as $row) {
            $items[] = call_user_func([static::FACTORY, 'create'], $row);
        }

        return new Collection($items);
    }

    /**
     * @return Collection
     * @throws InvalidArgumentException
     * @throws QueryExecutionException
     */
    public function getAllIndexedById()
    {
        try {
            $statement = $this->connection->query($this->selectQuery());
            $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new QueryExecutionException('Unable to get data from ' . __CLASS__, $e->getCode(), $e);
        }

        $collection = new Collection();
        foreach ($rows as $row) {
            $collection->addItem(
                call_user_func([static::FACTORY, 'create'], $row),
                $row['id']
            );
        }

        return $collection;
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws QueryExecutionException
     */
    public function delete($id)
    {
        try {
            $statement = $this->connection->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $statement->bindParam(':id', $id);
            return $statement->execute();
        } catch (\Exception $e) {
            throw new QueryExecutionException('Unable to delete data from ' . __CLASS__, $e->getCode(), $e);
        }
    }

    /**
     * @return string
     */
    protected function selectQuery()
    {
        return "SELECT * FROM {$this->table}";
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * @return bool
     */
    public function rollback()
    {
        return $this->connection->rollBack();
    }
}
