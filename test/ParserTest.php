<?php
use VKBansal\FrontMatter\Parser;
use VKBansal\FrontMatter\Document;

class ParserTest extends PHPUnit_Framework_TestCase{

    protected $sampleContent = "Main Title\n-----\n### Subtilte\n\nLorem ipsum......\n";

    protected $sampleHeader = [
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

    public function testYaml()
    {
        $yaml = file_get_contents(__DIR__.'/resources/yaml.md');
        
        $doc = Parser::parse($yaml);

        $this->assertEquals($this->sampleHeader, $doc->getConfig());
        $this->assertSame( $this->sampleContent, $doc->getContent());

        $doc = new Document($this->sampleContent, $this->sampleHeader);

        $this->assertEquals($yaml, Parser::dump($doc));
    }

    public function testYaml2()
    {
        $yaml = file_get_contents(__DIR__.'/resources/yaml2.md');
        
        $doc = Parser::parse($yaml);

        $this->assertEquals($this->sampleHeader, $doc->getConfig());
        $this->assertSame( $this->sampleContent, $doc->getContent());

        $doc = new Document($this->sampleContent, $this->sampleHeader);

        $this->assertEquals($yaml, Parser::dump($doc, Parser::DUMP_YAML));
    }
    

    public function testJson()
    {
        $json = file_get_contents(__DIR__.'/resources/json.md');
        
        $doc = Parser::parse($json);

        $this->assertEquals($this->sampleHeader, $doc->getConfig());
        $this->assertSame( $this->sampleContent, $doc->getContent());

        $doc = new Document($this->sampleContent, $this->sampleHeader);

        $this->assertEquals($json, Parser::dump($doc, Parser::DUMP_JSON));
    }

    public function testIni()
    {
        $ini = file_get_contents(__DIR__.'/resources/ini.md');
        
        $doc = Parser::parse($ini);

        $this->assertEquals($this->sampleHeader, $doc->getConfig());
        $this->assertSame( $this->sampleContent, $doc->getContent());

        $doc = new Document($this->sampleContent, $this->sampleHeader);

        $this->assertEquals($ini, Parser::dump($doc, Parser::DUMP_INI));
    }

    public function testParsingInvalidDoc()
    {
        $doc = Parser::parse('Lorem ipsum dol........');
        $this->assertEquals('Lorem ipsum dol........', $doc->getContent());
        $this->assertEmpty($doc->getConfig());
    }

    public function testDumpGarbage()
    {
        $document = new Document('<body>Hello</body>', array('title' => 'test', 'layout' => 'layout.html'));

        $dump = Parser::dump($document, 'aasddad');

        $this->assertSame("---\ntitle: test\nlayout: layout.html\n---\n<body>Hello</body>", $dump);
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
