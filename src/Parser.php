<?php
namespace VKBansal\FrontMatter;

use Symfony\Component\Yaml\Yaml;

/**
 * FrontMatter Parser
 * @package VKBansal\FrontMatter\Parser
 * @version 1.3.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Parser
{
    /**
     * Regex for seperators
     * @var string
     */
    private static $matcherRegex = "/^-{3}\s?(\w*)\r?\n(.*)\r?\n-{3}\r?\n(.*)/s";

    /**
     * Constanst for Document::dump()
     * @see Document::dump()
     */
    const DUMP_YAML = 'yaml';
    const DUMP_JSON = 'json';
    const DUMP_INI  = 'ini';

    /**
     * Parse the given content
     * @param  string $input content to be parsed
     * @return Document
     */
    public static function parse($input)
    {
        if (preg_match(self::$matcherRegex, $input, $matches)) {
            $header = self::parseHeader($matches[2], strtolower($matches[1]));
            $content = $matches[3];
        } else {
            $content = $input;
            $header = [];
        }

        return new Document($content, $header);
    }

    /**
     * Convert a Document to string
     * @param  Document $document
     * @return string
     */
    public static function dump (Document $document, $mode = null)
    {
        switch ($mode) {
            case 'yaml':
                return "--- yaml\n".Yaml::dump($document->getConfig())."---\n".$document->getContent();
            
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
     */
    public static function isValid($input)
    {
        return preg_match(self::$matcherRegex, $input) === 1;

    }

    /**
     * Parses header
     * @param  string $header
     * @param  string $parser
     * @return array|string
     */
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

    /**
     * Encodes PHP array to ini string
     * @param  array  $config
     * @return string
     */
    private static function dumpIni(array $config)
    {
        $sections = $globals = '';
        
        if (!empty($config)) {
            foreach ($config as $section => $item) {
                if (!is_array($item)) {
                    //To write globals at top
                    $globals .= "{$section} = {$item}\n";
                } else {
                    $sections = "\n[{$section}]\n";
                    foreach ($item as $key => $value) {
                        if (is_array($value)) {
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
