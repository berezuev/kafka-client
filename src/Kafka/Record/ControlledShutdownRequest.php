<?php
/**
 * @author Alexander.Lisachenko
 * @date 27.07.2014
 */

namespace Protocol\Kafka\Record;

use Protocol\Kafka;
use Protocol\Kafka\Record;

/**
 * This request asks for the controlled shutdown of specific broker
 */
class ControlledShutdownRequest extends AbstractRequest
{
    /**
     * Broker identifier to shutdown
     *
     * @var integer
     */
    private $brokerId;

    public function __construct($brokerId, $correlationId = 0, $clientId = '')
    {
        $this->brokerId = $brokerId;

        parent::__construct(Kafka::CONTROLLED_SHUTDOWN, $correlationId, $clientId, Kafka::VERSION_1);
    }

    /**
     * @inheritDoc
     */
    protected function packPayload()
    {
        $payload = parent::packPayload();

        $payload .= pack('N', $this->brokerId);

        return $payload;
    }
}
