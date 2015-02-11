<?php
/**
 * @author Tomasz Kunicki
 */

namespace Behat\PlaceholderExtension\Collection;

use Behat\PlaceholderExtension\Mapper\ObjectMapperInterface;


/**
 * Class Collection
 *
 * @package Behat\PlaceholderExtension\Collection
 */
interface CollectionInterface
{
    /**
     * @param ObjectMapperInterface $mapperInterface
     */
    public function add(ObjectMapperInterface $mapperInterface);
}
