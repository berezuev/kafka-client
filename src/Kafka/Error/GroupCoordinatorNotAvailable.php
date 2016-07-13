<?php

namespace Protocol\Kafka\Error;

use Exception;

/**
 * The group coordinator is not available.
 */
class GroupCoordinatorNotAvailable extends \RuntimeException implements KafkaException, RetriableException
{
    public function __construct($message, Exception $previous = null)
    {
        parent::__construct($message, self::GROUP_LOAD_IN_PROGRESS, $previous);
    }
}
