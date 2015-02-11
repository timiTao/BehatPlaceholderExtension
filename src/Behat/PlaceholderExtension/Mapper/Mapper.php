<?php
/**
 * @author Tomasz Kunicki
 */
namespace Behat\PlaceholderExtension\Mapper;

use Behat\PlaceholderExtension\Collection\CollectionInterface;
use Behat\PlaceholderExtension\Exception\PlaceholderException;

/**
 * Class Mapper
 *
 * @package Behat\PlaceholderExtension\Mapper
 */
class Mapper implements MapperInterface
{
    /**
     * @var CollectionInterface
     */
    protected $collection;

    /**
     * @param CollectionInterface $collection
     */
    function __construct(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param mixed $value
     * @return mixed
     * @throws \Behat\PlaceholderExtension\Exception\PlaceholderException
     */
    public function mapValue($value)
    {
        /** @var ObjectMapperInterface $objectMapper */
        foreach ($this->collection as $objectMapper) {
            if ($objectMapper->isSupportValue($value)) {
                return $objectMapper->map($value);
            }
        }

        throw new PlaceholderException(sprintf("Value couldn't '%s' mapped", $value));
    }
}
