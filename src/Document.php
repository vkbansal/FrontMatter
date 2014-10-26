<?php
namespace VKBansal\FrontMatter;

/**
 * FrontMatter Document
 * @package VKBansal\FrontMatter\Document
 * @version 1.0.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Document implements \ArrayAccess, \IteratorAggregate{

    /**
     * Constants for Document::merge() behaviour
     * @since 1.1.0
     */
    const MERGE_CONFIG = 0;
    const MERGE_CONTENT_REPLACE = 1;
    const MERGE_CONTENT_APPEND = 2;
    const MERGE_ALL_REPLACE = 3;
    const MERGE_ALL_APPEND = 4;

    /**
     * Constants for Document::inherit() behaviour
     * @since 1.1.0
     */
    const INHERIT_CONFIG = 5;
    const INHERIT_CONTENT_REPLACE = 6;
    const INHERIT_CONTENT_APPEND = 7;
    const INHERIT_ALL_REPLACE = 8;
    const INHERIT_ALL_APPEND = 9;
    
    /**
     * Content of the document 
     * @var string
     * @since 1.0.0
     */
    private $content;

    /**
     * Config of the document
     * @var array
     * @since 1.0.0
     */
    private $config;

    /**
     * Document Constructor
     * @param string $content content/body of the document
     * @param array  $config  config/header of the document
     * @since 1.0.0
     */
    public function __construct($content = '', $config = []){
        $this->content = $content;
        $this->config = $config;
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
        return $this->config[$name];
    }

    /**
     * @see "http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members"
     * @since 1.0.0
     */
    public function __set($name, $value){
        $this->config[$name] = $value;
    }

    /**
     * @see "http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members"
     * @return boolean
     * @since 1.0.0
     */
    public function __isset($name){
        return isset($this->config[$name]);
    }

    /**
     * @see "http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members"
     * @since 1.0.0
     */
    public function __unset($name){
        unset($this->config[$name]);
    }

    /**
     * Whether or not an offset exists.
     * This method is executed when using isset() or empty() on objects implementing ArrayAccess.
     * @see "http://php.net/manual/en/arrayaccess.offsetexists.php"
     * @since 1.0.0
     */
    public function offsetExists($offset){
        return isset($this->config[$offset]);
    }

    /**
     * Returns the value at specified offset.
     * This method is executed when checking if offset is empty().
     * @see http://php.net/manual/en/arrayaccess.offsetget.php
     * @since 1.0.0
     */
    public function offsetGet($offset){
        return $this->config[$offset];
    }

    /**
     * Assigns a value to the specified offset.
     * @see "http://php.net/manual/en/arrayaccess.offsetset.php"
     * @since 1.0.0
     */
    public function offsetSet($offset, $value){
        $this->config[$offset] = $value;
    }

    /**
     * Unsets an offset.
     * @see "http://php.net/manual/en/arrayaccess.offsetunset.php"
     * @since 1.0.0
     */
    public function offsetUnset($offset){
        unset($this->config[$offset]);
    }

    /**
     * @see "http://php.net/manual/en/class.iteratoraggregate.php"
     * @return void
     * @since 1.1.0
     */
    public function getIterator(){
        return new \ArrayIterator($this->config);
    }
    
    /**
     * Get header/config of the document
     * @param  mixed $varName  Name of the property to get
     * @return mixed           if name is specified, returns specific property else returns full config/header
     * @since 1.0.0
     */
    public function getConfig($varName = null){

        if($varName !== null && array_key_exists($varName, $this->config)){
            return $this->config[$varName];
        }

        return $this->config;
    }

    /**
     * Set header/config of the document
     * @param  mixed $property If an array is provided, header is replaced. If a string is provided, the poperty is replaced/set.
     * @param  mixed $value    Value of the property to set
     * @return $this
     * @since 1.0.0
     */
    public function setConfig($property, $value = null){

        if(is_array($property)){
            $this->config = $property;
        } elseif (is_string($property)){
            $this->config[$property] = $value;
        }
        return $this;
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
     * @return $this
     * @since 1.0.0
     */
    public function setContent($content){
        $this->content = $content;
        return $this;
    }

    /**
     * Inherit from parent document
     * @param  Document $parent Document to be inherited
     * @param  int      $mode   Inherit Mode
     * @return $this
     * @since 1.1.0
     */
    public function inherit(Document $parent, $mode = self::INHERIT_CONFIG){

        if(in_array($mode, [self::INHERIT_CONFIG, self::INHERIT_ALL_APPEND, self::INHERIT_ALL_REPLACE])){
            $this->config = $this->mergeRecursive($parent->getConfig(), $this->config);
        }

        if(in_array($mode, [self::INHERIT_ALL_REPLACE, self::INHERIT_CONTENT_REPLACE])){
            $this->content = $parent->getContent();
        }

        if(in_array($mode, [self::INHERIT_ALL_APPEND, self::INHERIT_CONTENT_APPEND])){
            $this->content = $parent->getContent().$this->content;
        }
        return $this;
    }

    /**
     * Merge current document with given document
     * @param  Document $document Document to be merged in
     * @param  int      $mode     Merge mode
     * @return $this
     * @since 1.1.0
     */
    public function merge(Document $document, $mode = self::MERGE_CONFIG){

        if(in_array($mode, [self::MERGE_CONFIG, self::MERGE_ALL_APPEND, self::MERGE_ALL_REPLACE])){
            $this->config = $this->mergeRecursive($this->config, $document->getConfig());
        }

        if(in_array($mode, [self::MERGE_ALL_REPLACE, self::MERGE_CONTENT_REPLACE])){
            $this->content = $document->getContent();
        }

        if(in_array($mode, [self::MERGE_ALL_APPEND, self::MERGE_CONTENT_APPEND])){
            $this->content .= $document->getContent();
        }

        return $this;
    }

    /**
     * Recursively merges second array into first
     * @param  array $itemA Array to be merged in
     * @param  array $itemB Array to be merged
     * @return array        merged array
     * @since 1.1.0
     */
    private function mergeRecursive($itemA, $itemB){
        
        foreach ($itemB as $key => $value) {
            if(is_integer($key)){
                $itemA[] = $value;
            } elseif (array_key_exists($key, $itemA) && is_array($itemA[$key]) && is_array($value)){
                $itemA[$key] = $this->mergeRecursive($itemA[$key], $value);
            }
            else{
                $itemA[$key] = $value;
            }
        }

        return $itemA;
    }
}