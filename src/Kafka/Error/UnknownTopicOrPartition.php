<?php

namespace Protocol\Kafka\Error;

use Exception;

/**
 * This server does not host this topic-partition.
 */
class UnknownTopicOrPartition extends \InvalidArgumentException implements KafkaException, RetriableException
{
    public function __construct($message, Exception $previous = null)
    {
        parent::__construct($message, self::UNKNOWN_TOPIC_OR_PARTITION, $previous);
    }
}
