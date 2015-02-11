<?php
/**
 * @author Tomasz Kunicki
 */
namespace Behat\PlaceholderExtension\Mappers;

use Behat\PlaceholderExtension\Mapper\ObjectMapperInterface;

/**
 * Class DefaultObjectMapper
 *
 * @package Behat\PlaceholderExtension\Mappers
 */
class DefaultObjectMapper extends \ArrayObject implements ObjectMapperInterface
{
    /**
     * @param $value
     * @return boolean
     */
    public function isSupportValue($value)
    {
        return $this->offsetExists($value);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function map($value)
    {
        return $this->offsetGet($value);
    }
}
