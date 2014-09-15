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
     */
    private static $yamlSeperator = "/^-{3}\r?\n(.*)\r?\n-{3}\r?\n/s";

    /**
     * Regex for JSON seperators
     * @var string
     * @since 1.0.0
     */
    private static $jsonSeperator = "/^;{3}\r?\n(.*)\r?\n;{3}\r?\n/s";

    /**
     * Parse the given content
     * @param  string $input content to be parsed
     * @return Document
     * @since 1.0.0
     */
    public static function parse($input){
        
        $content = $header = null;
        
        if(preg_match(self::$yamlSeperator,  $input, $matches)) {
        
            $content = substr($input, strlen($matches[0]));
            $header = Yaml::parse($matches[1]);

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
}