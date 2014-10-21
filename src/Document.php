<?php
namespace VKBansal\FrontMatter;

/**
 * FrontMatter Document
 * @package VKBansal\FrontMatter\Document
 * @version 1.0.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Document implements \ArrayAccess{
    
    private $content;

    private $header;

    /**
     * Document Constructor
     * @param string $content content/body of the document
     * @param array  $header  config/header of the document
     * @since 1.0.0
     */
    public function __construct($content = '', $header = []){
        $this->content = $content;
        $this->header = $header;
    }

    /**
     * @see "http://php.net/manual/en/language.oop5.magic.php#object.tostring"
     * @return string
     * @since 1.0.0
     */
    public function __toString(){
        return $this->getContent();
    }


    /**
     * @see "http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members"
     * @return mixed
     * @since 1.0.0
     */
    public function __get($name){
        return $this->header[$name];
    }

    /**
     * @see "http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members"
     * @since 1.0.0
     */
    public function __set($name, $value){
        $this->header[$name] = $value;
    }

    /**
     * @see "http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members"
     * @return boolean
     * @since 1.0.0
     */
    public function __isset($name){
        return isset($this->header[$name]);
    }

    /**
     * @see "http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members"
     * @since 1.0.0
     */
    public function __unset($name){
        unset($this->header[$name]);
    }

    /**
     * Whether or not an offset exists.
     * This method is executed when using isset() or empty() on objects implementing ArrayAccess.
     * @see "http://php.net/manual/en/arrayaccess.offsetexists.php"
     * @since 1.0.0
     */
    public function offsetExists($offset){
        return isset($this->header[$offset]);
    }

    /**
     * Returns the value at specified offset.
     * This method is executed when checking if offset is empty().
     * @see http://php.net/manual/en/arrayaccess.offsetget.php
     * @since 1.0.0
     */
    public function offsetGet($offset){
        return $this->header[$offset];
    }

    /**
     * Assigns a value to the specified offset.
     * @see "http://php.net/manual/en/arrayaccess.offsetset.php"
     * @since 1.0.0
     */
    public function offsetSet($offset, $value){
        $this->header[$offset] = $value;
    }

    /**
     * Unsets an offset.
     * @see "http://php.net/manual/en/arrayaccess.offsetunset.php"
     * @since 1.0.0
     */
    public function offsetUnset($offset){
        unset($this->header[$offset]);
    }
    
    /**
     * Get header/config of the document
     * @param  mixed $varName  Name of the property to get
     * @return mixed           if name is specified, returns specific property else returns full config/header
     * @since 1.0.0
     */
    public function getConfig($varName = null){

        if($varName !== null && array_key_exists($varName, $this->header)){
            return $this->header[$varName];
        }

        return $this->header;
        
    }

    /**
     * Set header/config of the document
     * @param  mixed $property If an array is provided, header is replaced. If a string is provided, the poperty is replaced/set.
     * @param  mixed $value    Value of the property to set
     * @since 1.0.0
     */
    public function setConfig($property, $value = null){

        if(is_array($property)){
            $this->header = $property;
        } elseif (is_string($property)){
            $this->header[$property] = $value;
        }
    }

    /**
     * Get the content of the document
     * @return string Content of the document
     * @since 1.0.0
     */
    public function getContent(){
        return $this->content;
    }

    /**
     * Set the content of the document
     * @param string  $content Content of the document
     * @since 1.0.0
     */
    public function setContent($content){
        $this->content = $content;
    }
}