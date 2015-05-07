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
class Struct
{
    private $name;

    private $properties;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }

    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;
    }

    public function getProperty($name)
    {
        if ($this->hasProperty($name)) {
            return $this->properties[$name];
        }
    }

    public function hasProperty($name)
    {
        return array_key_exists($name, $this->properties);
    }
}
