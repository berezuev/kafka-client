<?php

namespace Protocol\Kafka\Error;

use Exception;

/**
 * The request included a message larger than the max message size the server will accept.
 */
class MessageTooLarge extends KafkaException implements ServerExceptionInterface
{
    public function __construct(array $context, Exception $previous = null)
    {
        parent::__construct($context, self::MESSAGE_TOO_LARGE, $previous);
    }
}
