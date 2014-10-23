<?php

namespace spec\VKBansal\FrontMatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use VKBansal\FrontMatter\Document;

class ParserSpec extends ObjectBehavior
{
    function it_should_parse_yaml(){

        $this->parse(file_get_contents(__DIR__.'/../../resources/yaml.md'))->getConfig()->shouldReturn([
            'layout' => 'custom',
            'my_list' => [ 'one', 'two', 'three']
        ]);
        $this->parse(file_get_contents(__DIR__.'/../../resources/yaml.md'))->getContent()->shouldReturn(<<<EOF
Main Title
-----
### Subtilte

Lorem ipsum......
EOF
        );
    }

    function it_should_parse_json(){

        $this->parse(file_get_contents(__DIR__.'/../../resources/json.md'))->getConfig()->shouldReturn([
            'layout' => 'custom',
            'my_list' => [ 'one', 'two', 'three']
        ]);
        $this->parse(file_get_contents(__DIR__.'/../../resources/json.md'))->getContent()->shouldReturn(<<<EOF
Main Title
-----
### Subtilte

Lorem ipsum......
EOF
        );
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
        $this->isValid(file_get_contents(__DIR__.'/../../resources/yaml.md'))->shouldBeTrue();
        $this->isValid(file_get_contents(__DIR__.'/../../resources/json.md'))->shouldBeTrue();
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