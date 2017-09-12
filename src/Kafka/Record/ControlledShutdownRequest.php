<?php
/**
 * @author Alexander.Lisachenko
 * @date 27.07.2014
 */

namespace Protocol\Kafka\Record;

use Protocol\Kafka;

/**
 * This request asks for the controlled shutdown of specific broker
 */
class ControlledShutdownRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    const VERSION = 1;

    /**
     * Broker identifier to shutdown
     *
     * @var integer
     */
    private $brokerId;

    public function __construct($brokerId, $clientId = '', $correlationId = 0)
    {
        $this->brokerId = $brokerId;

        parent::__construct(Kafka::CONTROLLED_SHUTDOWN, $clientId, $correlationId);
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
