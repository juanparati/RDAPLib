<?php


namespace Juanparati\RDAPLib\Models\Helpers;


/**
 * Class CardModel
 *
 * @package Juanparati\RDAPLib\Models\Helpers
 */
class CardModel
{

    /**
     * Parsed card.
     *
     * @var array
     */
    protected $card = [];


    /**
     * CardModel constructor.
     *
     * @param array $card
     */
    public function __construct(array $card)
    {
        $this->card = $card;
    }


    /**
     * Return the CardModel as array.
     *
     * @return array
     */
    public function asArray() : array
    {
        return $this->card;
    }


    /**
     * Get entry with all their attributes.
     *
     * @param string $name
     * @return array|null
     */
    public function getWithAttr(string $name) : ?array
    {
        $num_records = isset($this->card[$name]) ? count($this->card[$name]) : 0;

        if (!$num_records)
            return null;

        if ($num_records === 1)
            return $this->card[$name][0];

        return $this->card[$name];
    }


    /**
     * Return the card entry and their value.
     *
     * @param $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        $value = $this->getWithAttr($name);

        if ($value === null)
            return null;

        return $value['value'] ?? array_map(function ($record) { return $record['value']; }, $value);
    }

}
