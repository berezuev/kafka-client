<?php
/**
 * @author Alexander.Lisachenko
 * @date 14.07.2016
 */

namespace Protocol\Kafka\Record;

use Protocol\Kafka;
use Protocol\Kafka\Scheme;

/**
 * This API answers the following questions:
 *
 *      What topics exist?
 *      How many partitions does each topic have?
 *      Which broker is currently the leader for each partition?
 *      What is the host and port for each of these brokers?
 *
 * This is the only request that can be addressed to any broker in the cluster.
 * Since there may be many topics the client can give an optional list of topic names in order to only return metadata
 * for a subset of topics.
 *
 * The metadata returned is at the partition level, but grouped together by topic for convenience and to avoid
 * redundancy. For each partition the metadata contains the information for the leader as well as for all the replicas
 * and the list of replicas that are currently in-sync.
 *
 * Note: If "auto.create.topics.enable" is set in the broker configuration, a topic metadata request will create the
 * topic with the default replication factor and number of partitions.
 */
class MetadataRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    const VERSION = 2;

    /**
     * An array of topics to fetch metadata for. If no topics are specified fetch metadata for all topics.
     *
     * @var string
     */
    protected $topics;

    public function __construct(array $topics = null, $clientId = '', $correlationId = 0)
    {
        $this->topics = $topics;

        parent::__construct(Kafka::METADATA, $clientId, $correlationId);
    }

    public static function getScheme()
    {
        $header = parent::getScheme();

        return $header + [
            'topics' => [Scheme::TYPE_STRING, Scheme::FLAG_NULLABLE => true]
        ];
    }
}
