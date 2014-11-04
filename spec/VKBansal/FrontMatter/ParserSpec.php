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

    private $sample_content = <<<EOF
Main Title
-----
### Subtilte

Lorem ipsum......
EOF;

    private $dir;

    function let()
    {
        $this->dir = __DIR__.'/../../../test/resources/';
    }

    function it_should_parse_yaml()
    {
        $this->parse(file_get_contents($this->dir.'yaml.md'))
             ->getConfig()
             ->shouldReturn($this->sample_header);
        
        $this->parse(file_get_contents($this->dir.'yaml.md'))
             ->getContent()
             ->shouldReturn($this->sample_content);
    }

    function it_should_parse_json()
    {
        $this->parse(file_get_contents($this->dir.'json2.md'))
             ->getConfig()
             ->shouldReturn($this->sample_header);
        
        $this->parse(file_get_contents($this->dir.'json2.md'))
             ->getContent()
             ->shouldReturn($this->sample_content);
    }

    function it_should_dump_yaml(){
        $document = new Document('<body>Hello</body>', ['title' => 'test', 'layout' => 'layout.html']);
        $this->dump($document)->shouldReturn(<<<EOF
---
title: test
layout: layout.html
---
<body>Hello</body>
EOF
        );
    }

    function it_should_dump_json(){
        $document = new Document('<body>Hello</body>', ['title' => 'test', 'layout' => 'layout.html']);
        $this->dump($document, true)->shouldReturn(<<<EOF
;;;
{
    "title": "test",
    "layout": "layout.html"
}
;;;
<body>Hello</body>
EOF
        );
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
