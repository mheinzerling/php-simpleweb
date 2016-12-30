<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\message;

use Eloquent\Enumeration\AbstractEnumeration;


/**
 * @method static Status OK()
 * @method static Status Moved_Permanently()
 * @method static Status Found();
 * @method static Status Forbidden();
 * @method static Status Not_Found();
 * @method static Status Internal_Server_Error();
 */
class Status extends AbstractEnumeration
{
    const OK = 200;
    const Moved_Permanently = 301;
    const Found = 302;
    const Forbidden = 403;
    const Not_Found = 404;
    const Internal_Server_Error = 500;
}