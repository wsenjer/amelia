<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace AmeliaBooking\Domain\Repository\Bookable\Service;

use AmeliaBooking\Domain\Repository\BaseRepositoryInterface;

/**
 * Interface ServiceRepositoryInterface
 *
 * @package AmeliaBooking\Domain\Repository\Bookable\Service
 */
interface ServiceRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $serviceId
     * @param $userId
     *
     * @return mixed
     */
    public function getProviderServiceWithExtras($serviceId, $userId);

    /**
     * @param $serviceId
     *
     * @return mixed
     */
    public function getByIdWithExtras($serviceId);

    /**
     * @param $categoryId
     *
     * @return mixed
     */
    public function getAllForCategory($categoryId);
}
