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
class Collection extends \ArrayObject implements CollectionInterface
{
    /**
     * @param ObjectMapperInterface $mapperInterface
     */
    public function add(ObjectMapperInterface $mapperInterface)
    {
        $this->append($mapperInterface);
    }
}
