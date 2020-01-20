<?php


namespace Juanparati\RDAPLib\Helpers;


use Juanparati\RDAPLib\Models\Helpers\CardModel;

/**
 * Class RdapJCardParser.
 *
 * It is a custom jCard adapted to RDAP.
 *
 * It seems that RDAP jCard are not using a standard structure so standard it's not possible
 * to use custom jCard parsers like the Sabre\VObject.
 *
 * @package Juanparati\RDAPLib\Helpers
 */
class RdapJCardParser
{

    /**
     * Fields supported by RDAP jCard
     */
    const FIELDS = [
        'adr'         => 'address',
        'contact-uri' => 'contact uri',
        'email'       => 'email',
        'fn'          => 'name',
        'geo'         => 'geo',
        'kind'        => 'kind',
        'lang'        => 'language',
        'org'         => 'organization',
        'role'        => 'role',
        'tel'         => 'phone',
        'title'       => 'title',
        'version'     => 'version',
        'links'       => 'links'
    ];


    /**
     *
     * @param array $jCard
     * @return CardModel
     */
    public static function parse(array $jCard) : CardModel
    {
        $card = [];

        foreach ($jCard as $entry)
        {

            $label = static::FIELDS[$entry[0]] ?? null;

            if (!$label)
                continue;

            $index = $entry[0];

            if ($index === 'adr' && isset($entry[1]['label']))
                $value = $entry[1]['label'];
            else
                $value = $entry[3];

            $card[$index][] =
            [
                'property' => $index,
                'label'    => $label,
                'type'     => $entry[1]['type'] ?? null,
                'value'    => $value,
            ];
        }

        return new CardModel($card);
    }

}
