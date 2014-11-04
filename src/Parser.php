<?php
namespace VKBansal\FrontMatter;

use Symfony\Component\Yaml\Yaml;

/**
 * FrontMatter Parser
 * @package VKBansal\FrontMatter\Parser
 * @version 1.0.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Parser {

    /**
     * Regex for YAML seperators
     * @var string
     * @since 1.0.0
     * @depricated  since 1.2.0
     */
    private static $yamlSeperator = "/^-{3}\r?\n(.*)\r?\n-{3}\r?\n/s";

    /**
     * Regex for JSON seperators
     * @var string
     * @since 1.0.0
     * @depricated  since 1.2.0
     */
    private static $jsonSeperator = "/^;{3}\r?\n(.*)\r?\n;{3}\r?\n/s";

    /**
     * Regex for seperators
     * @var string
     * @since 1.2.0
     */
    private static $matcherRegex = "/^-{3}\s?(\w*)\r?\n(.*)\r?\n-{3}\r?\n(.*)/s";

    /**
     * Parse the given content
     * @param  string $input content to be parsed
     * @return Document
     * @since 1.0.0
     */
    public static function parse($input){
        
        $content = $header = null;

        if(preg_match(self::$matcherRegex, $input, $matches)){
            $header = self::parseHeader($matches[2], strtolower($matches[1]));
            $content = $matches[3];
        } elseif (preg_match( self::$jsonSeperator, $input, $matches)) {   
            $content = substr($input, strlen($matches[0]));
            $header = json_decode($matches[1], true);
        } else {
            $content = $input;
        }

        return new Document($content, $header);
    }

    /**
     * Convert a Document to string
     * @param  Document $document
     * @return string
     * @since 1.0.0
     */
    public static function dump (Document $document, $asJSON = false){
        if(!$asJSON){
            return "---\n".Yaml::dump($document->getConfig())."---\n".$document->getContent();
        } else {
            return ";;;\n".json_encode($document->getConfig(), JSON_PRETTY_PRINT)."\n;;;\n".$document->getContent();
        }
    }

    /**
     * Determines if given content is valid 
     * @param  string  $input  Input to be validated
     * @return boolean         True if valid else false
     * @since 1.1.0 
     */
    public static function isValid($input){

        return (preg_match(self::$matcherRegex, $input) === 1) || (preg_match(self::$jsonSeperator, $input) === 1);

    }

    private static function parseHeader($header, $parser)
    {
        switch($parser){
            case 'yaml':
                return Yaml::parse($header);
            case 'json':
                return json_decode($header, true);
            default:
                return Yaml::parse($header);
        }
    }
}