<?php namespace Calc\Model;

class CalulationWrapper
{
    public $facade = 0;
    public $skeleton = 0;
    public $furniture = 0;
    public $construct_assembly = 0;
    public $total = 0;
    public $num = 0;
    /**
     * @var  Calculation $object
     */
    protected $object;

    function __construct($object)
    {
        $this->object = $object;
        $this->construct_assembly = $object->additionalCoefficient->value
            * ($object->cost_construct + $object->cost_assembly);
    }

    function __get($name)
    {
        return $this->object->{$name};
    }

    public function totalWithInstallAndDelivery()
    {
        return $this->total + $this->object->delivery + $this->object->install;
    }
}
