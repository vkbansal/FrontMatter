<?php

namespace spec\VKBansal\FrontMatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use VKBansal\FrontMatter\Document;

class ParserSpec extends ObjectBehavior
{
    private $sample_header = [
        'layout' => 'custom',
        'my_list' => [ 'one', 'two', 'three']
    ];

    private $sample_content = "Main Title\n-----\n### Subtilte\n\nLorem ipsum......";

    private $dir;

    private $document;

    function let()
    {
        $this->dir = __DIR__.'/../../../test/resources/';
        $this->document = new Document('<body>Hello</body>', ['title' => 'test', 'layout' => 'layout.html']);
    }

    function it_should_parse_yaml()
    {
        $this->parse(file_get_contents($this->dir.'yaml.md'))
             ->getConfig()
             ->shouldReturn($this->sample_header);
        
        $this->parse(file_get_contents($this->dir.'yaml2.md'))
             ->getContent()
             ->shouldReturn($this->sample_content);
    }

    function it_should_parse_json()
    {
        $this->parse(file_get_contents($this->dir.'json.md'))
             ->getConfig()
             ->shouldReturn($this->sample_header);
        
        $this->parse(file_get_contents($this->dir.'json2.md'))
             ->getContent()
             ->shouldReturn($this->sample_content);
    }

    function it_should_parse_ini()
    {
        $this->parse(file_get_contents($this->dir.'ini.md'))
             ->getConfig()
             ->shouldReturn($this->sample_header);
    }

    function it_should_dump_yaml(){
        $this->dump($this->document)
             ->shouldReturn("---\ntitle: test\nlayout: layout.html\n---\n<body>Hello</body>");
    }

    function it_should_dump_json(){
        $this->dump($this->document, true)
             ->shouldReturn(";;;\n{\n    \"title\": \"test\",\n    \"layout\": \"layout.html\"\n}\n;;;\n<body>Hello</body>");
    }

    function it_should_dump_json2()
    {
        $this->dump($this->document, 'json')
             ->shouldReturn("--- json\n{\n    \"title\": \"test\",\n    \"layout\": \"layout.html\"\n}\n---\n<body>Hello</body>");
    }

    function it_should_dump_ini()
    {
        $this->dump($this->document, 'ini')
             ->shouldReturn("--- ini\ntitle = test\nlayout = layout.html\n---\n<body>Hello</body>");   
    }

    function it_should_validate_automatically(){
        $this->isValid(file_get_contents($this->dir.'yaml.md'))->shouldBeTrue();
        $this->isValid(file_get_contents($this->dir.'json.md'))->shouldBeTrue();
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
