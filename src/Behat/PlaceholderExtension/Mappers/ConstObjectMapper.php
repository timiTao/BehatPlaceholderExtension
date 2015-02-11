<?php
/**
 * @author Tomasz Kunicki
 */
namespace Behat\PlaceholderExtension\Mappers;

use Behat\PlaceholderExtension\Mapper\ObjectMapperInterface;

/**
 * Class ConstObjectMapper
 *
 * @package Behat\PlaceholderExtension\Mappers
 */
class ConstObjectMapper implements ObjectMapperInterface
{
    /**
     * @var array
     */
    protected $list = [
        "NULL" => NULL,
        "TRUE" => TRUE,
        "FALSE" => FALSE
    ];

    /**
     * @param $value
     * @return boolean
     */
    public function isSupportValue($value)
    {
        return array_key_exists($value, $this->list);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function map($value)
    {
        return $this->list[$value];
    }
}
