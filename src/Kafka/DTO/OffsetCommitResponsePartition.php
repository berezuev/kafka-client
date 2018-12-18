<?php
/**
 * @author Alexander.Lisachenko
 * @date 14.07.2014
 */

namespace Protocol\Kafka\DTO;

use Protocol\Kafka\BinarySchemeInterface;
use Protocol\Kafka\Scheme;

/**
 * OffsetCommitResponsePartition DTO
 *
 * OffsetCommitResponsePartition => partition error_code
 *   partition => INT32
 *   error_code => INT16
 */
class OffsetCommitResponsePartition implements BinarySchemeInterface
{
    /**
     * The partition this request entry corresponds to.
     *
     * @var integer
     */
    public $partition;

    /**
     * The error from this partition, if any.
     *
     * @var integer
     */
    public $errorCode;

    /**
     * Returns definition of binary packet for the class or object
     *
     * @return array
     */
    public static function getScheme(): array
    {
        return [
            'partition' => Scheme::TYPE_INT32,
            'errorCode' => Scheme::TYPE_INT16
        ];
    }
}
