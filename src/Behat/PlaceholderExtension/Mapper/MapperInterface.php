<?php
/**
 * @author Tomasz Kunicki
 */
namespace Behat\PlaceholderExtension\Mapper;

/**
 * Class Mapper
 *
 * @package Behat\PlaceholderExtension\Mapper
 */
interface MapperInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function mapValue($value);
}
