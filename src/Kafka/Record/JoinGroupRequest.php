<?php
/**
 * @author Alexander.Lisachenko
 * @date 14.07.2016
 */

namespace Protocol\Kafka\Record;

use Protocol\Kafka;

/**
 * Join Group Request
 *
 * The join group request is used by a client to become a member of a group. When new members join an existing group,
 * all previous members are required to rejoin by sending a new join group request. When a member first joins the
 * group, the memberId will be empty (i.e. ""), but a rejoining member should use the same memberId from the previous
 * generation.
 */
class JoinGroupRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    const VERSION = 1;

    /**
     * Member id for self-assigned consumer
     */
    const DEFAULT_MEMBER_ID = "";

    /**
     * The consumer group id.
     *
     * @var string
     */
    private $consumerGroup;

    /**
     * The coordinator considers the consumer dead if it receives no heartbeat after this timeout in ms.
     *
     * @var int
     */
    private $sessionTimeout;

    /**
     * The maximum time that the coordinator will wait for each member to rejoin when rebalancing the group
     *
     * @var int
     */
    private $rebalanceTimeout;

    /**
     * The member id assigned by the group coordinator.
     *
     * @var string
     */
    private $memberId;

    /**
     * Unique name for class of protocols implemented by group
     *
     * @var string
     */
    private $protocolType;

    /**
     * List of protocols that the member supports as key=>value pairs, where value is metadata
     *
     * @var array
     */
    private $groupProtocols;

    public function __construct(
        $consumerGroup,
        $sessionTimeout,
        $rebalanceTimeout,
        $memberId,
        $protocolType,
        array $groupProtocols,
        $clientId = '',
        $correlationId = 0
    ) {
        $this->consumerGroup    = $consumerGroup;
        $this->sessionTimeout   = $sessionTimeout;
        $this->rebalanceTimeout = $rebalanceTimeout;
        $this->memberId         = $memberId;
        $this->protocolType     = $protocolType;
        $this->groupProtocols   = $groupProtocols;

        parent::__construct(Kafka::JOIN_GROUP, $clientId, $correlationId);
    }

    /**
     * @inheritDoc
     *
     * JoinGroup Request (Version: 0) => group_id session_timeout member_id protocol_type [group_protocols]
     *   group_id => STRING
     *   session_timeout => INT32
     *   rebalance_timeout => INT32
     *   member_id => STRING
     *   protocol_type => STRING
     *   group_protocols => protocol_name protocol_metadata
     *     protocol_name => STRING
     *     protocol_metadata => BYTES
     */
    protected function packPayload()
    {
        $payload        = parent::packPayload();
        $groupLength    = strlen($this->consumerGroup);
        $memberLength   = strlen($this->memberId);
        $protocolLength = strlen($this->protocolType);

        $payload .= pack(
            "na{$groupLength}NNna{$memberLength}na{$protocolLength}N",
            $groupLength,
            $this->consumerGroup,
            $this->sessionTimeout,
            $this->rebalanceTimeout,
            $memberLength,
            $this->memberId,
            $protocolLength,
            $this->protocolType,
            count($this->groupProtocols)
        );

        foreach ($this->groupProtocols as $protocolName => $protocolMetadata) {
            $protocolNameLength = strlen($protocolName);
            $protocolMetaLength = strlen($protocolMetadata);
            $payload .= pack("na{$protocolNameLength}N", $protocolNameLength, $protocolName, $protocolMetaLength);
            $payload .= $protocolMetadata;
        }

        return $payload;
    }
}
