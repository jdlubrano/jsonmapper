<?php

class JsonUnmapper
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

       if((strcasecmp(gettype($object), 'object') !== 0) && (!is_array($object)))
       {
           return $object;

       }else if(is_array($object))
       {
           foreach($object as &$val)
           {
               $val = $this->arrayify($val);
           }

           return $object;
       }

       // The object is not a primitive nor an array.

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
    public function unmap($object) 
    { 
        return json_encode($this->arrayify($object)); 
    }

}

