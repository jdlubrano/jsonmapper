<?php

/**
 * JsonSerializer Class
 *
 * Provides functionality to serialize a PHP
 * object to JSON format.
 */
class JsonSerializer
{
    /**
     * Converts the given object to a JSON string.
     *
     * @param $object   The object
     *
     * @return array    An associative array that represents
     *                  that maps the object's properties to their
     *                  values.  Nested objects are also represented
     *                  as arrays.
     */
    protected function arrayify($object)
    {
       $array = array();

       if(strcasecmp(gettype($object), 'object') !== 0)
       {
           return $object;
       }

       $rc = new ReflectionClass($object);

       foreach($rc->getProperties() as $property)
       {
           $propertyValue = NULL;

           $propertyName = $property->getName();

           if($property->isPublic())
           {
               $propertyValue = $object->$propertyName;
           
           }else
           {
               $getter = 'get' . ucfirst($propertyName);
               
               if($rc->hasMethod($getter))
               {
                   $method = $rc->getMethod($getter);

                   if($method->isPublic())
                   {
                       $propertyValue = $object->$getter();
                   }
               }
           }

           $array[$propertyName] = $this->arrayify($propertyValue);
       }

       return $array;
    }

    /**
     * Converts the given object into an equivalent JSON string.
     *
     * @var $object     The object
     *
     * @return string   The JSON representation of the object.
     */
    public function jsonSerialize($object) 
    { 
        return json_encode($this->arrayify($object)); 
    }

}

