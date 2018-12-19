<?php
/*
 * This file is part of the Alpari Kafka client.
 *
 * (c) Alpari
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types=1);

namespace Alpari\Kafka\Error;

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
