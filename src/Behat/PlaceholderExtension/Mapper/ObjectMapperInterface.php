<?php
/**
 * @author Tomasz Kunicki
 */
namespace Behat\PlaceholderExtension\Mapper;

/**
 * Interface MapperInterface
 *
 * @package Behat\PlaceholderExtension\Mapper
 */
interface ObjectMapperInterface
{
    /**
     * @param $value
     * @return boolean
     */
    public function isSupportValue($value);

    /**
     * @param mixed $value
     * @return mixed
     */
    public function map($value);
}
