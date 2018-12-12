<?php
/**
 * @author Alexander.Lisachenko
 * @date 14.07.2016
 */

namespace Protocol\Kafka\DTO;

use Protocol\Kafka\BinarySchemeInterface;
use Protocol\Kafka\Scheme;

/**
 * OffsetsRequestPartition DTO
 *
 * OffsetsRequestPartition => partition timestamp
 *   partition => INT32
 *   timestamp => INT64
 */
class OffsetsRequestPartition implements BinarySchemeInterface
{
    /**
     * Topic partition id
     *
     * @var integer
     */
    public $partition;

    /**
     * The target timestamp for the partition.
     *
     * @var integer
     */
    public $timestamp;

    /**
     * Default constructor
     *
     * @param integer $partition
     * @param integer $timestamp
     */
    public function __construct($partition, $timestamp)
    {
        $this->partition = $partition;
        $this->timestamp = $timestamp;
    }

    /**
     * Returns definition of binary packet for the class or object
     *
     * @return array
     */
    public static function getScheme()
    {
        return [
            'partition' => Scheme::TYPE_INT32,
            'timestamp' => Scheme::TYPE_INT64
        ];
    }
}
