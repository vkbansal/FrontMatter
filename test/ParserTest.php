<?php
use VKBansal\FrontMatter\Parser;
use VKBansal\FrontMatter\Document;

class ParserTest extends PHPUnit_Framework_TestCase{

    public function testParse(){
        $yaml = file_get_contents(__DIR__.'/resources/yaml.md');
        $json = file_get_contents(__DIR__.'/resources/json.md');

        $doc_y = Parser::parse($yaml);
        $doc_j = Parser::parse($json);

        $this->assertEquals([
            'layout' => 'custom',
            'my_list' => [ 'one', 'two', 'three']
        ], $doc_y->getConfig());

        $this->assertSame(<<<EOF
Main Title
-----
### Subtilte

Lorem ipsum......
EOF
        , $doc_y->getContent());

        $this->assertSame([
            'layout' => 'custom',
            'my_list' => [ 'one', 'two', 'three']
        ], $doc_j->getConfig());

        $this->assertEquals(<<<EOF
Main Title
-----
### Subtilte

Lorem ipsum......
EOF
        , $doc_j->getContent());
    }

    public function testDump()
    {
        $document = new Document('<body>Hello</body>', array('title' => 'test', 'layout' => 'layout.html'));

        $dump_y = Parser::dump($document);

        $this->assertSame(<<<EOF
---
title: test
layout: layout.html
---
<body>Hello</body>
EOF
        , $dump_y);

        $dump_j = Parser::dump($document, true);

        $this->assertSame(<<<EOF
;;;
{
    "title": "test",
    "layout": "layout.html"
}
;;;
<body>Hello</body>
EOF
        , $dump_j);
    }

    public function testIsValid(){
        $yaml = file_get_contents(__DIR__.'/resources/yaml.md');
        $json = file_get_contents(__DIR__.'/resources/json.md');

        $test =  'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et aut molestias quam vitae voluptatibus a quod, aliquid. Ipsam alias repudiandae, similique in odit eum quod voluptatibus, repellat minima explicabo fuga.';

        $this->assertTrue(Parser::isValid($yaml));
        $this->assertTrue(Parser::isValid($json));
        $this->assertFalse(Parser::isValid($test));
    }
}