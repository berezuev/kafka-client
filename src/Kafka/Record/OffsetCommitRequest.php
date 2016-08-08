<?php
/**
 * @author Alexander.Lisachenko
 * @date 14.07.2016
 */

namespace Protocol\Kafka\Record;

use Protocol\Kafka;
use Protocol\Kafka\DTO\OffsetCommitPartition;
use Protocol\Kafka\Record;

/**
 * OffsetCommit
 *
 * This api saves out the consumer's position in the stream for one or more partitions. In the scala API this happens
 * when the consumer calls commit() or in the background if "autocommit" is enabled. This is the position the consumer
 * will pick up from if it crashes before its next commit().
 */
class OffsetCommitRequest extends AbstractRequest
{
    /**
     * The consumer group id.
     *
     * @var string
     */
    private $consumerGroup;

    /**
     * The generation of the group.
     *
     * @var int
     * @since Version 1 of protocol
     */
    private $generationId;

    /**
     * The member id assigned by the group coordinator.
     *
     * @var string
     * @since Version 1 of protocol
     */
    private $memberName;

    /**
     * @var array
     */
    private $topicPartitions;

    public function __construct(
        $consumerGroup,
        $generationId,
        $memberName,
        array $topicPartitions,
        $clientId = '',
        $correlationId = 0
    ) {

        $this->consumerGroup   = $consumerGroup;
        $this->generationId    = $generationId;
        $this->memberName      = $memberName;
        $this->topicPartitions = $topicPartitions;

        parent::__construct(Kafka::OFFSET_COMMIT, $clientId, $correlationId);
    }

    /**
     * @inheritDoc
     */
    protected function packPayload()
    {
        $payload      = parent::packPayload();
        $groupLength  = strlen($this->consumerGroup);
        $memberLength = strlen($this->memberName);
        $totalTopics  = count($this->topicPartitions);

        $payload .= pack(
            "na{$groupLength}Nna{$memberLength}N",
            $groupLength,
            $this->consumerGroup,
            $this->generationId,
            $memberLength,
            $this->memberName,
            $totalTopics
        );

        foreach ($this->topicPartitions as $topic => $partitions) {
            $topicLength = strlen($topic);
            $payload    .= pack("na{$topicLength}N", $topicLength, $topic, count($partitions));
            /** @var OffsetCommitPartition $partition */
            foreach ($partitions as $partitionId => $partition) {
                if (!is_object($partition)) {
                    // short-cut to store only offsetst, in this case $partition is offset
                    $partition = OffsetCommitPartition::fromPartitionOffset($partitionId, $partition);
                }
                $payload .= (string) $partition;
            }
        }

        return $payload;
    }
}
