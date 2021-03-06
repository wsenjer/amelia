<?php
/**
 * Assembling repositories:
 * Instantiating infrastructure-layer repositories implementing the Domain layer interfaces
 */

use AmeliaBooking\Infrastructure\Common\Container;
use AmeliaBooking\Infrastructure\WP\InstallActions\DB;
use AmeliaBooking\Infrastructure\Repository;

defined('ABSPATH') or die('No script kiddies please!');

$entries['domain.bookable.category.repository'] = function (Container $c) {
    return new Repository\Bookable\Service\CategoryRepository(
        $c->getDatabaseConnection(),
        DB\Bookable\CategoriesTable::getTableName()
    );
};

$entries['domain.bookable.extra.repository'] = !AMELIA_LITE_VERSION ? function (Container $c) {
    return new Repository\Bookable\Service\ExtraRepository(
        $c->getDatabaseConnection(),
        DB\Bookable\ExtrasTable::getTableName()
    );
} : function () {};

$entries['domain.bookable.service.repository'] = function (Container $c) {
    return new Repository\Bookable\Service\ServiceRepository(
        $c->getDatabaseConnection(),
        DB\Bookable\ServicesTable::getTableName(),
        DB\User\Provider\ProvidersServiceTable::getTableName(),
        DB\Bookable\ExtrasTable::getTableName(),
        DB\Bookable\ServicesViewsTable::getTableName(),
        DB\Gallery\GalleriesTable::getTableName(),
        DB\User\UsersTable::getTableName()
    );
};

$entries['domain.coupon.repository'] = function (Container $c) {
    return new Repository\Coupon\CouponRepository(
        $c->getDatabaseConnection(),
        DB\Coupon\CouponsTable::getTableName(),
        DB\Bookable\ServicesTable::getTableName(),
        DB\Coupon\CouponsToServicesTable::getTableName(),
        DB\Booking\CustomerBookingsTable::getTableName()
    );
};

$entries['domain.coupon.service.repository'] = function (Container $c) {
    return new Repository\Coupon\CouponServiceRepository(
        $c->getDatabaseConnection(),
        DB\Coupon\CouponsToServicesTable::getTableName()
    );
};

$entries['domain.locations.repository'] = function (Container $c) {
    return new Repository\Location\LocationRepository(
        $c->getDatabaseConnection(),
        DB\Location\LocationsTable::getTableName(),
        DB\User\Provider\ProvidersLocationTable::getTableName(),
        DB\User\Provider\ProvidersServiceTable::getTableName(),
        DB\Bookable\ServicesTable::getTableName(),
        DB\Location\LocationsViewsTable::getTableName()
    );
};

$entries['domain.notification.repository'] = function (Container $c) {
    return new Repository\Notification\NotificationRepository(
        $c->getDatabaseConnection(),
        DB\Notification\NotificationsTable::getTableName()
    );
};

$entries['domain.notificationLog.repository'] = function (Container $c) {
    return new Repository\Notification\NotificationLogRepository(
        $c->getDatabaseConnection(),
        DB\Notification\NotificationsLogTable::getTableName(),
        DB\Notification\NotificationsTable::getTableName(),
        DB\Booking\AppointmentsTable::getTableName(),
        DB\Booking\CustomerBookingsTable::getTableName(),
        DB\User\UsersTable::getTableName()
    );
};

$entries['domain.payment.repository'] = function (Container $c) {
    return new Repository\Payment\PaymentRepository(
        $c->getDatabaseConnection(),
        DB\Payment\PaymentsTable::getTableName(),
        DB\Booking\AppointmentsTable::getTableName(),
        DB\Booking\CustomerBookingsTable::getTableName(),
        DB\Bookable\ServicesTable::getTableName(),
        DB\User\UsersTable::getTableName()
    );
};

$entries['domain.users.repository'] = function (Container $c) {
    return new Repository\User\UserRepository(
        $c->getDatabaseConnection(),
        DB\User\UsersTable::getTableName()
    );
};

$entries['domain.bookable.service.providerService.repository'] = function (Container $c) {
    return new Repository\Bookable\Service\ProviderServiceRepository(
        $c->getDatabaseConnection(),
        DB\User\Provider\ProvidersServiceTable::getTableName()
    );
};

$entries['domain.bookable.service.providerLocation.repository'] = function (Container $c) {
    return new Repository\Location\ProviderLocationRepository(
        $c->getDatabaseConnection(),
        DB\User\Provider\ProvidersLocationTable::getTableName()
    );
};

$entries['domain.schedule.dayOff.repository'] = !AMELIA_LITE_VERSION ? function (Container $c) {
    return new Repository\Schedule\DayOffRepository(
        $c->getDatabaseConnection(),
        DB\User\Provider\ProvidersDayOffTable::getTableName()
    );
} : function () {};

$entries['domain.schedule.weekDay.repository'] = function (Container $c) {
    return new Repository\Schedule\WeekDayRepository(
        $c->getDatabaseConnection(),
        DB\User\Provider\ProvidersWeekDayTable::getTableName()
    );
};

$entries['domain.schedule.timeOut.repository'] = function (Container $c) {
    return new Repository\Schedule\TimeOutRepository(
        $c->getDatabaseConnection(),
        DB\User\Provider\ProvidersTimeOutTable::getTableName()
    );
};

$entries['domain.users.providers.repository'] = function (Container $c) {
    return new Repository\User\ProviderRepository(
        $c->getDatabaseConnection(),
        DB\User\UsersTable::getTableName(),
        DB\User\Provider\ProvidersWeekDayTable::getTableName(),
        DB\User\Provider\ProvidersTimeOutTable::getTableName(),
        DB\User\Provider\ProvidersDayOffTable::getTableName(),
        DB\User\Provider\ProvidersServiceTable::getTableName(),
        DB\User\Provider\ProvidersLocationTable::getTableName(),
        DB\Bookable\ServicesTable::getTableName(),
        DB\User\Provider\ProvidersViewsTable::getTableName(),
        DB\User\Provider\ProvidersGoogleCalendarTable::getTableName()
    );
};

$entries['domain.users.customers.repository'] = function (Container $c) {
    return new Repository\User\CustomerRepository(
        $c->getDatabaseConnection(),
        DB\User\UsersTable::getTableName()
    );
};

$entries['domain.wpUsers.repository'] = function (Container $c) {
    return new Repository\User\WPUserRepository(
        $c->getDatabaseConnection(),
        DB\User\WPUsersTable::getTableName(),
        DB\User\WPUsersTable::getMetaTableName(),
        DB\User\WPUsersTable::getDatabasePrefix()
    );
};

$entries['domain.booking.appointment.repository'] = function (Container $c) {
    return new Repository\Booking\Appointment\AppointmentRepository(
        $c->getDatabaseConnection(),
        DB\Booking\AppointmentsTable::getTableName(),
        DB\Bookable\ServicesTable::getTableName(),
        DB\Booking\CustomerBookingsTable::getTableName(),
        DB\Booking\CustomerBookingsToExtrasTable::getTableName(),
        DB\Bookable\ExtrasTable::getTableName(),
        DB\User\UsersTable::getTableName(),
        DB\Payment\PaymentsTable::getTableName(),
        DB\Coupon\CouponsTable::getTableName(),
        DB\User\Provider\ProvidersLocationTable::getTableName(),
        DB\User\Provider\ProvidersServiceTable::getTableName()
    );
};

$entries['domain.booking.customerBooking.repository'] = function (Container $c) {
    return new Repository\Booking\Appointment\CustomerBookingRepository(
        $c->getDatabaseConnection(),
        DB\Booking\CustomerBookingsTable::getTableName()
    );
};

$entries['domain.booking.customerBookingExtra.repository'] = !AMELIA_LITE_VERSION ? function (Container $c) {
    return new Repository\Booking\Appointment\CustomerBookingExtraRepository(
        $c->getDatabaseConnection(),
        DB\Booking\CustomerBookingsToExtrasTable::getTableName()
    );
} : function () {};

$entries['domain.galleries.repository'] = function (Container $c) {
    return new Repository\Gallery\GalleryRepository(
        $c->getDatabaseConnection(),
        DB\Gallery\GalleriesTable::getTableName()
    );
};

$entries['domain.google.calendar.repository'] = function (Container $c) {
    return new Repository\Google\GoogleCalendarRepository(
        $c->getDatabaseConnection(),
        DB\User\Provider\ProvidersGoogleCalendarTable::getTableName()
    );
};

$entries['domain.customField.repository'] = function (Container $c) {
    return new Repository\CustomField\CustomFieldRepository(
        $c->getDatabaseConnection(),
        DB\CustomField\CustomFieldsTable::getTableName(),
        DB\CustomField\CustomFieldsOptionsTable::getTableName(),
        DB\CustomField\CustomFieldsServicesTable::getTableName(),
        DB\Bookable\ServicesTable::getTableName(),
        DB\Bookable\CategoriesTable::getTableName()
    );
};

$entries['domain.customFieldOption.repository'] = function (Container $c) {
    return new Repository\CustomField\CustomFieldOptionRepository(
        $c->getDatabaseConnection(),
        DB\CustomField\CustomFieldsOptionsTable::getTableName()
    );
};

$entries['domain.customFieldService.repository'] = function (Container $c) {
    return new Repository\CustomField\CustomFieldServiceRepository(
        $c->getDatabaseConnection(),
        DB\CustomField\CustomFieldsServicesTable::getTableName()
    );
};