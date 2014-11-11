<?php

namespace spec\VKBansal\FrontMatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use VKBansal\FrontMatter\Document;

class ParserSpec extends ObjectBehavior
{
    private $sample_header = [
        "host" => "http://example.com",
        "port" => 25,
        "user" => [
            "name" => [
                "first" => "John",
                "last" => "Doe"
            ],
            "id" => "johndoe@example.com",
            "password" => "mypassword"
        ]
    ];

    private $sample_content = "Main Title\n-----\n### Subtilte\n\nLorem ipsum......\n";

    private $dir;

    private $document;

    function let()
    {
        $this->dir = __DIR__.'/../../../test/resources/';
        $this->document = new Document($this->sample_content, $this->sample_header);
    }

    function it_should_parse_yaml_as_default()
    {   
        $yaml = file_get_contents($this->dir.'yaml.md');
        $this->parse($yaml)->getConfig()->shouldReturn($this->sample_header);
        $this->parse($yaml)->getContent()->shouldReturn($this->sample_content);
        $this->dump($this->document)->shouldReturn($yaml);      
    }

    function it_should_parse_yaml()
    {   
        $yaml = file_get_contents($this->dir.'yaml2.md');
        $this->parse($yaml)->getConfig()->shouldReturn($this->sample_header);
        $this->parse($yaml)->getContent()->shouldReturn($this->sample_content);
        $this->dump($this->document, 'yaml')->shouldReturn($yaml);
    }


    function it_should_parse_json()
    {   
        $json = file_get_contents($this->dir.'json.md');
        $this->parse($json)->getConfig()->shouldReturn($this->sample_header);
        $this->parse($json)->getContent()->shouldReturn($this->sample_content);
        $this->dump($this->document, 'json')->shouldReturn($json);
   }

    function it_should_parse_json_deprecated()
    {   
        $json = file_get_contents($this->dir.'json2.md');
        $this->parse($json)->getConfig()->shouldReturn($this->sample_header);
        $this->parse($json)->getContent()->shouldReturn($this->sample_content);
        $this->dump($this->document, true)->shouldReturn($json);
   }

    function it_should_parse_ini()
    {   
        $ini = file_get_contents($this->dir.'ini.md');
        $this->parse($ini)->getConfig()->shouldBeLike($this->sample_header);
        $this->parse($ini)->getContent()->shouldReturn($this->sample_content);
        $this->dump($this->document, 'ini')->shouldReturn($ini);
   }

    function it_should_validate_automatically(){
        $this->isValid(file_get_contents($this->dir.'yaml.md'))->shouldBeTrue();
        $this->isValid(file_get_contents($this->dir.'json.md'))->shouldBeTrue();
        $this->isValid(file_get_contents($this->dir.'ini.md'))->shouldBeTrue();
        $this->isValid('Lorem Ipsum')->shouldBeFalse();
    }

    public function getMatchers(){
        return [
            'beTrue' => function($subject) {
                return $subject === true;
            },
            'beFalse' => function($subject) {
                return $subject === false;
            },
        ];
    }
}
