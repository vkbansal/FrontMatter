<?php
use VKBansal\FrontMatter\Document;

class DocumentTest extends PHPUnit_Framework_TestCase{

    protected $document;

    public function setUp(){
        $this->document = new Document('Lorem Ipsum.....', ['title'=> 'Random Title', 'category' => 'just another category']);
        
    }

    public function testContent(){

        $this->assertEquals('Lorem Ipsum.....', $this->document->getContent());
        $this->assertEquals('Lorem Ipsum.....', $this->document);

        $this->document->setContent('Lorem ipsum');
        $this->assertEquals('Lorem ipsum', $this->document->getContent());

    }

    public function testConfig(){
        $this->assertEquals(['title'=> 'Random Title', 'category' => 'just another category'], $this->document->getConfig());
        $this->assertEquals('Random Title', $this->document->getConfig('title'));

        $this->document->setConfig('title', 'Random Post Title');
        $this->assertEquals('Random Post Title', $this->document->getConfig('title'));

        $this->document->setConfig(['title'=> 'Random Title', 'category' => 'yet another category']);
        $this->assertEquals(['title'=> 'Random Title', 'category' => 'yet another category'], $this->document->getConfig());
    }

    public function testArrayAccess(){
        $this->assertEquals('Random Title', $this->document['title']);
        $this->document['title'] = 'Title';
        $this->assertEquals('Title', $this->document['title']);

        unset($this->document['title']);

        $this->assertFalse(isset($this->document['title']));
    }
}