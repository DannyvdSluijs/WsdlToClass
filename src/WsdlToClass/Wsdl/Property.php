<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace WsdlToClass\Wsdl;
/**
 * Description of Struct
 *
 * @author dannyvandersluijs
 */
class Property
{
    private $name;

    private $type;

    public function __construct($name, $type)
    {
        $this->name = (string) $name;
        $this->type = (string) $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = (string) $type;
        return $this;
    }
}
