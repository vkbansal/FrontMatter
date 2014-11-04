<?php
use VKBansal\FrontMatter\Parser;
use VKBansal\FrontMatter\Document;

class ParserTest extends PHPUnit_Framework_TestCase{

    protected $sampleContent = <<<EOF
Main Title
-----
### Subtilte

Lorem ipsum......
EOF;

    protected $sampleHeader = [
        'layout' => 'custom',
        'my_list' => [ 'one', 'two', 'three']
    ];

    public function testParseYaml(){
        $yaml = file_get_contents(__DIR__.'/resources/yaml.md');
        
        $doc = Parser::parse($yaml);

        $this->assertEquals($this->sampleHeader, $doc->getConfig());
        $this->assertSame( $this->sampleContent, $doc->getContent());
    }

    public function testParseJson(){
        $json = file_get_contents(__DIR__.'/resources/json.md');
        
        $doc = Parser::parse($json);

        $this->assertEquals($this->sampleHeader, $doc->getConfig());
        $this->assertSame( $this->sampleContent, $doc->getContent());
    }

    public function testParseYaml2(){
        $yaml = file_get_contents(__DIR__.'/resources/yaml2.md');
        
        $doc = Parser::parse($yaml);

        $this->assertEquals($this->sampleHeader, $doc->getConfig());
        $this->assertSame( $this->sampleContent, $doc->getContent());
    }

    public function testParseJson2(){
        $json = file_get_contents(__DIR__.'/resources/json2.md');
        
        $doc = Parser::parse($json);

        $this->assertEquals($this->sampleHeader, $doc->getConfig());
        $this->assertSame( $this->sampleContent, $doc->getContent());
    }

    public function testDumpYaml()
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
    }

    public function testDumpJSON()
    {
        $document = new Document('<body>Hello</body>', array('title' => 'test', 'layout' => 'layout.html'));

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

    public function testDumpJSON2()
    {
        $document = new Document('<body>Hello</body>', array('title' => 'test', 'layout' => 'layout.html'));

        $dump_j = Parser::dump($document, Parser::DUMP_JSON);

        $this->assertSame(<<<EOF
--- json
{
    "title": "test",
    "layout": "layout.html"
}
---
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