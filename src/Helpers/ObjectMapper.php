<?php


namespace Juanparati\RDAPLib\Helpers;


/**
 * Class ObjectMapper.
 *
 * @package Juanparati\RDAPLib\Helpers
 */
class ObjectMapper
{

    /**
     * List of collections.
     *
     * @var array
     */
    protected $collections = [];


    /**
     * List of fields.
     *
     * @var array
     */
    protected $fields = [];


    /**
     * Register a collection.
     *
     * @param string $objectField
     * @param string $jsonField
     * @param string $modelClass
     */
    public function registerCollection(string $objectField, string $jsonField, string $modelClass)
    {
        $this->collections[$jsonField] = [$objectField, $modelClass];
    }


    /**
     * Register a new field.
     *
     * @param string $objectField
     * @param string $jsonField
     * @param string $modelClass
     * @param string|null $modelField
     */
    public function registerField(
        string $objectField,
        string $jsonField,
        string $modelClass,
        ?string $modelField = null)
    {
        $modelField = $modelField ?: $objectField;
        $this->fields[$jsonField] = [$objectField, $modelClass, $modelField];
    }


    /**
     * Map to object.
     *
     * @param array $data
     * @param string|null $model
     * @return mixed
     */
    public function map(array $data, string $model = null)
    {
        $node  = new $model;

        foreach ($data as $jsonField => $jsonValue)
        {
            if (isset($this->fields[$jsonField]))
            {
                [$objectField, $modelClass, $modelField] = $this->fields[$jsonField];
                $node->{$objectField} = $this->transformField($jsonValue, $modelClass, $modelField);
            }
            else if (isset($this->collections[$jsonField]))
            {
                [$objectField, $modelClass] = $this->collections[$jsonField];
                $node->{$objectField} = $this->transformCollection($jsonValue, $modelClass);
            }
            else if ($jsonField === 'rdapConformance' || property_exists($node, $jsonField))
                $node->{$jsonField} = $jsonValue;

        }

        return $node;
    }


    /**
     * Transform field.
     *
     * @param $data
     * @param string $model
     * @param string $modelField
     * @return mixed
     */
    protected function transformField($data, string $model, ?string $modelField)
    {
        $object = new $model;

        if ($modelField)
            $object->{$modelField} = $data;
        else
        {
            foreach ($data as $k => $value)
                $object->{$k} = $value;
        }

        return $object;
    }


    /**
     * Transform collection.
     *
     * @param array $data
     * @param string $model
     * @return array
     */
    protected function transformCollection(array $data, string $model) : array
    {
        $nodes  = [];

        foreach ($data as $jsonField)
            $nodes[] = $this->map($jsonField, $model);

        return $nodes;
    }
}
