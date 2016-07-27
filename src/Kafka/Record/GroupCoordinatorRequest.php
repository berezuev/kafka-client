<?php
/**
 * @author Alexander.Lisachenko
 * @date 14.07.2014
 */

namespace Protocol\Kafka\Record;

use Protocol\Kafka;
use Protocol\Kafka\Record;

/**
 * The offsets for a given consumer group are maintained by a specific broker called the group coordinator. i.e., a
 * consumer needs to issue its offset commit and fetch requests to this specific broker.
 *
 * It can discover the current coordinator by issuing a group coordinator request.
 */
class GroupCoordinatorRequest extends AbstractRequest
{
    /**
     * The consumer group id.
     *
     * @var string
     */
    private $consumerGroup;

    public function __construct($consumerGroup, $correlationId = 0, $clientId = '')
    {
        $this->consumerGroup   = $consumerGroup;

        parent::__construct(Kafka::GROUP_COORDINATOR, $correlationId, $clientId, Kafka::VERSION_0);
    }

    /**
     * @inheritDoc
     */
    protected function packPayload()
    {
        $payload     = parent::packPayload();
        $groupLength = strlen($this->consumerGroup);

        $payload .= pack("na{$groupLength}", $groupLength, $this->consumerGroup);

        return $payload;
    }
}
