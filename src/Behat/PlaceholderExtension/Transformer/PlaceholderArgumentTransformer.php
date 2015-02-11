<?php
/**
 * @author Tomasz Kunicki
 */
namespace Behat\PlaceholderExtension\Transformer;


use Behat\Behat\Definition\Call\DefinitionCall;
use Behat\Behat\Transformation\Transformer\ArgumentTransformer;
use Behat\Gherkin\Node\ArgumentInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\PlaceholderExtension\Mapper\MapperInterface;

/**
 * Class PlaceholderArgumentTransformer
 *
 * @package Behat\PlaceholderExtension\Transformer
 */
class PlaceholderArgumentTransformer implements ArgumentTransformer
{
    /**
     * @var MapperInterface
     */
    protected $mapper;

    /**
     * @var string
     */
    protected $pattern;

    /**
     * @param $mapper
     * @param string $pattern
     */
    function __construct($mapper, $pattern)
    {
        $this->mapper = $mapper;
        $this->pattern = $pattern;
    }


    /**
     * Checks if transformer supports argument.
     *
     * @param DefinitionCall $definitionCall
     * @param integer|string $argumentIndex
     * @param mixed $argumentValue
     *
     * @return Boolean
     */
    public function supportsDefinitionAndArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue)
    {
        return !is_object($argumentValue) || $argumentValue instanceof ArgumentInterface;
    }

    /**
     * Transforms argument value using transformation and returns a new one.
     *
     * @param DefinitionCall $definitionCall
     * @param integer|string $argumentIndex
     * @param mixed $argumentValue
     *
     * @return mixed
     */
    public function transformArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue)
    {
        if ($argumentValue instanceof TableNode) {
            return $this->transformTableNode($argumentValue);
        }
        if ($argumentValue instanceof PyStringNode) {
            return $this->transformPyString($argumentValue);
        }
        if (is_array($argumentValue)) {
            return $argumentValue;
        }

        return $this->transformValue($argumentValue);
    }

    /**
     * @param TableNode $table
     * @return TableNode
     */
    protected function transformTableNode(TableNode $table)
    {
        $tempList = $table->getTable();
        foreach ($tempList as $key => $row) {
            foreach ($row as $columnKey => $column) {
                $newValue = $this->transformValue($column);
                $tempList[$key][$columnKey] = $newValue;
            }
        }

        return new TableNode($tempList);
    }

    /**
     * @param PyStringNode $stringNode
     * @return PyStringNode
     */
    protected function transformPyString(PyStringNode $stringNode)
    {
        $newValue = $this->transformValue($stringNode->getRaw());
        $strings = explode("\n", $newValue);

        return new PyStringNode($strings, $stringNode->getLine());
    }

    /**
     * @param mixed $argumentValue
     * @return mixed
     */
    protected function transformValue($argumentValue)
    {
        if (!preg_match_all($this->getPattern(), $argumentValue, $matches)) {
            return $argumentValue;
        }

        if (count($matches[0]) == 1) {
            $placeholder = $matches[0][0];
            $value = $matches[1][0];
            if (strlen($placeholder) == strlen($argumentValue)) {
                return $this->mapper->mapValue($value);
            } else {
                $mappedValue = $this->mapper->mapValue($value);

                return str_replace($placeholder, $mappedValue, $argumentValue);
            }
        }

        $placeholders = $matches[0];
        $values = $matches[1];

        foreach ($values as $key => $value) {
            $newValue = $this->mapper->mapValue($value);
            $values[$key] = $newValue;
        }

        return str_replace($placeholders, $values, $argumentValue);
    }

    /**
     * @return string
     */
    protected function getPattern()
    {
        return $this->pattern;
    }
}
