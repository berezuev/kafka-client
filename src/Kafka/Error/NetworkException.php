<?php

namespace Protocol\Kafka\Error;

use Exception;

/**
 * The server disconnected before a response was received.
 */
class NetworkException extends \RuntimeException implements KafkaException, RetriableException
{
    public function __construct($message, Exception $previous = null)
    {
        parent::__construct($message, self::NETWORK_EXCEPTION, $previous);
    }
}
