<?php


namespace Juanparati\RDAPLib;

use Juanparati\RDAPLib\Helpers\ObjectMapper;


/**
 * Class AllTransformers.
 *
 * @package Juanparati\RDAPLib\Models
 */
class ModelMapper
{

    /**
     * Array bindings.
     */
    const ARRAY_BINDINGS =
    [
        'asEventActor',
        'autnums'     ,
        'dsData'      ,
        'entities'    ,
        'events'      ,
        'keyData'     ,
        'links'       ,
        'nameservers' ,
        'networks'    ,
        'notices'     ,
        'publicIds'   ,
        'remarks'     ,
        'variants'    ,
    ];


    /**
     * Field bindings.
     */
    const FIELD_BINDINGS =
    [
        'ipAddresses' => null,
        'network'     => null,
        'secureDNS'   => null,
        'vcardArray'  => 'data',
    ];


    /**
     * Available models.
     *
     * @var array
     */
    protected $models =
    [
        'asEventActor' => \Juanparati\RDAPLib\Models\AsEventActorModel::class,
        'autnum'       => \Juanparati\RDAPLib\Models\AutnumModel::class,
        'autnums'      => \Juanparati\RDAPLib\Models\AutnumModel::class,
        'domain'       => \Juanparati\RDAPLib\Models\DomainModel::class,
        'dsData'       => \Juanparati\RDAPLib\Models\DsDataModel::class,
        'entities'     => \Juanparati\RDAPLib\Models\EntityModel::class,
        'entity'       => \Juanparati\RDAPLib\Models\EntityModel::class,
        'events'       => \Juanparati\RDAPLib\Models\EventModel::class,
        'ipAddresses'  => \Juanparati\RDAPLib\Models\IpAddressModel::class,
        'keyData'      => \Juanparati\RDAPLib\Models\KeyDataModel::class,
        'links'        => \Juanparati\RDAPLib\Models\LinkModel::class,
        'nameservers'  => \Juanparati\RDAPLib\Models\NameserverModel::class,
        'network'      => \Juanparati\RDAPLib\Models\IpNetworkModel::class,
        'networks'     => \Juanparati\RDAPLib\Models\IpNetworkModel::class,
        'notices'      => \Juanparati\RDAPLib\Models\NoticeModel::class,
        'publicIds'    => \Juanparati\RDAPLib\Models\PublicIdModel::class,
        'remarks'      => \Juanparati\RDAPLib\Models\RemarkModel::class,
        'secureDNS'    => \Juanparati\RDAPLib\Models\SecureDNSModel::class,
        'variants'     => \Juanparati\RDAPLib\Models\VariantModel::class,
        'vcardArray'   => \Juanparati\RDAPLib\Models\VCardArrayModel::class,
    ];


    /**
     * Object mapper instance.
     *
     * @var ObjectMapper
     */
    protected $objectMapper;


    /**
     * ModelMapper constructor.
     */
    public function __construct(array $models = [])
    {

        $this->models = array_merge($this->models, $models);

        $this->objectMapper = new ObjectMapper();

        foreach (static::ARRAY_BINDINGS as $model)
            $this->objectMapper->registerCollection($model, $model, $this->models[$model]);

        foreach (static::FIELD_BINDINGS as $model => $map)
            $this->objectMapper->registerField($model, $model, $this->models[$model], $map);
    }


    /**
     * Obtain the assigned class model.
     *
     * @param string $model
     * @return string
     */
    public function getClassModel(string $model) : string
    {
        return $this->models[$model];
    }


    /**
     * Return ObjectMapper instance.
     *
     * @return ObjectMapper
     */
    public function getObjectMapper() : ObjectMapper
    {
        return $this->objectMapper;
    }

}
