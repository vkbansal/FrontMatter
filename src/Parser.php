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
     * Regex for JSON seperators
     * @var string
     * @since 1.0.0
     * @deprecated  since 1.2.0
     */
    private static $jsonSeperator = "/^;{3}\r?\n(.*)\r?\n;{3}\r?\n/s";

    /**
     * Regex for seperators
     * @var string
     * @since 1.2.0
     */
    private static $matcherRegex = "/^-{3}\s?(\w*)\r?\n(.*)\r?\n-{3}\r?\n(.*)/s";

    const DUMP_YAML = 'yaml';
    const DUMP_JSON = 'json';
    const DUMP_INI  = 'ini';

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
    public static function dump (Document $document, $mode = self::DUMP_YAML)
    {
        //Deprecated
        if($mode === true){
            return ";;;\n".json_encode($document->getConfig(), JSON_PRETTY_PRINT)."\n;;;\n".$document->getContent();
        }

        switch ($mode) {
            case 'yaml':
                return "---\n".Yaml::dump($document->getConfig())."---\n".$document->getContent();

            case 'json':
                return "--- json\n".json_encode($document->getConfig(), JSON_PRETTY_PRINT)."\n---\n".$document->getContent();
            case 'ini':
                return "--- ini\n".self::dumpIni($document->getConfig())."---\n".$document->getContent();

            default:
                return "---\n".Yaml::dump($document->getConfig())."---\n".$document->getContent();
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
            case 'ini':
                return parse_ini_string($header, true);
            default:
                return Yaml::parse($header);
        }
    }


    private static function dumpIni(array $config)
    {
        $sections = $globals = '';
        
        if(!empty($config)){
            foreach ($config as $section => $item) {
                if(!is_array($item)){
                    //To write globals at top
                    $globals .= "{$section} = {$item}\n";
                } else {
                    $sections = "\n[{$section}]\n";
                    foreach ($item as $key => $value) {
                        if(is_array($value)){
                            foreach ($value as $arrKey => $arrValue) {
                                $sections .= "{$key}[{$arrKey}] = $arrValue\n";
                            }
                        } else {
                            $sections .= "{$key} = {$value}\n";
                        }
                    }
                }

            }
        }
        return $globals.$sections;
    }
}
