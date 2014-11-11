<?php
use VKBansal\FrontMatter\Document;

class DocumentTest extends PHPUnit_Framework_TestCase{

    protected $document;

    public function setUp()
    {
        $this->document = new Document('Lorem Ipsum.....', ['title'=> 'Random Title', 'category' => 'just another category']);    
    }

    public function testContent()
    {
        $this->assertEquals('Lorem Ipsum.....', $this->document->getContent());
        $this->assertEquals('Lorem Ipsum.....', $this->document);

        $this->document->setContent('Lorem ipsum');
        $this->assertEquals('Lorem ipsum', $this->document->getContent());

    }

    public function testConfig()
    {
        $this->assertEquals(['title'=> 'Random Title', 'category' => 'just another category'], $this->document->getConfig());
        $this->assertEquals('Random Title', $this->document->getConfig('title'));

        $this->document->setConfig('title', 'Random Post Title');
        $this->assertEquals('Random Post Title', $this->document->getConfig('title'));

        $this->document->setConfig(['title'=> 'Random Title', 'category' => 'yet another category']);
        $this->assertEquals(['title'=> 'Random Title', 'category' => 'yet another category'], $this->document->getConfig());
    }

    public function testArrayAccess()
    {
        $this->assertEquals('Random Title', $this->document['title']);
        $this->document['title'] = 'Title';
        $this->assertEquals('Title', $this->document['title']);

        unset($this->document['title']);

        $this->assertFalse(isset($this->document['title']));
    }

    public function testPropertyAccess()
    {
        $this->assertEquals('Random Title', $this->document->title);
        $this->document->title = 'Title';
        $this->assertEquals('Title', $this->document->title);

        unset($this->document->title);

        $this->assertFalse(isset($this->document->title));   
    }

    public function testMergeOnlyCconfig()
    {   
        $config1 = [
            'title'=> 'Random Title', 
            'category' => 'just another category',
            'nested' => [
                'a', 
                'b' => [
                    'b1',
                    'b2'
                ]
            ]
        ];
        
        $config2 = [
            'title'=> 'Not A Random Title', 
            'layout' => 'qwerty',
            'nested' => [ 
                'b' => [
                    'b3' => ['b31', 'b32'=>['b321']]
                ], 
                'c',
                'd'
            ]
        ];

        $nested = [ 
            'a',
            'b' => [
                'b1',
                'b2',
                'b3' => ['b31', 'b32'=>['b321']]
            ], 
            'c',
            'd'
        ];

        $doc1 = new Document('Lorem Ipsum.....', $config1);
        $doc2 = new Document('Lorem Ipsum dol sidur.....', $config2);
        
        $doc1->merge($doc2);
        
        $this->assertEquals('Not A Random Title', $doc1['title']);
        $this->assertEquals('qwerty', $doc1['layout']);
        $this->assertEquals('just another category', $doc1['category']);
        $this->assertEquals($nested, $doc1['nested']);
        $this->assertEquals('Lorem Ipsum.....', $doc1->getContent());
    
    }

    public function testMergeContentByReplacing()
    {
        $newDoc = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'someIndex' => 'qwerty']);
        $this->document->merge($newDoc, Document::MERGE_CONTENT_REPLACE);
        $this->assertEquals($this->document['title'], 'Random Title');
        $this->assertEquals($this->document['category'], 'just another category');
        $this->assertFalse(isset($this->document['someIndex']));
        $this->assertEquals($this->document->getContent(), 'Lorem Ipsum dol sidur.....');

    }

    public function testMergeContentByAppending()
    {
        $newDoc = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'someIndex' => 'qwerty']);
        $this->document->merge($newDoc, Document::MERGE_CONTENT_APPEND);
        $this->assertEquals($this->document['title'], 'Random Title');
        $this->assertEquals($this->document['category'], 'just another category');
        $this->assertFalse(isset($this->document['someIndex']));
        $this->assertEquals($this->document->getContent(), 'Lorem Ipsum.....Lorem Ipsum dol sidur.....');
    
    }

    public function testMergeAllByReplacing()
    {
        $newDoc = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'someIndex' => 'qwerty']);
        $this->document->merge($newDoc, Document::MERGE_ALL_REPLACE);
        $this->assertEquals($this->document['title'], 'Not A Random Title');
        $this->assertEquals($this->document['someIndex'], 'qwerty');
        $this->assertEquals($this->document['category'], 'just another category');
        $this->assertEquals($this->document->getContent(), 'Lorem Ipsum dol sidur.....');
    
    }

    public function testMergeAllByAppending()
    {
        $newDoc = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'someIndex' => 'qwerty']);
        $this->document->merge($newDoc, Document::MERGE_ALL_APPEND);
        $this->assertEquals($this->document['title'], 'Not A Random Title');
        $this->assertEquals($this->document['someIndex'], 'qwerty');
        $this->assertEquals($this->document['category'], 'just another category');
        $this->assertEquals($this->document->getContent(), 'Lorem Ipsum.....Lorem Ipsum dol sidur.....');
    }

    function testInheritOnlyConfig()
    {
        $config1 = [
            'title'=> 'Random Title', 
            'category' => 'just another category',
            'nested' => [
                'a', 
                'b' => [
                    'b1',
                    'b2'
                ]
            ]
        ];
        
        $config2 = [
            'title'=> 'Not A Random Title', 
            'layout' => 'grid',
            'nested' => [ 
                'b' => [
                    'b3' => ['b31', 'b32'=>['b321']]
                ], 
                'c',
                'd'
            ]
        ];

        $nested = [ 
            'a',
            'b' => [
                'b1',
                'b2',
                'b3' => ['b31', 'b32'=>['b321']]
            ], 
            'c',
            'd'
        ];
        $doc1 = new Document('Lorem Ipsum.....', $config1);
        $doc2 = new Document('Lorem Ipsum dol sidur.....', $config2);
        
        $doc2->inherit($doc1);

        $this->assertEquals('Not A Random Title', $doc2['title']);
        $this->assertEquals('just another category', $doc2['category']);
        $this->assertEquals('grid', $doc2['layout']);
        $this->assertEquals($nested, $doc2['nested']);
        $this->assertEquals('Lorem Ipsum dol sidur.....', $doc2->getContent());
    
    }

    function testInheritContentByReplacing()
    {
        $parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
        $this->document->inherit($parent, Document::INHERIT_CONTENT_REPLACE);
        $this->assertEquals($this->document['title'], 'Random Title');
        $this->assertEquals($this->document['category'], 'just another category');
        $this->assertFalse(isset($this->document['layout']));
        $this->assertEquals($this->document->getContent(), 'Lorem Ipsum dol sidur.....');

    }

    function testInheritContentByAppending()
    {
        $parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
        $this->document->inherit($parent, Document::INHERIT_CONTENT_APPEND);
        $this->assertEquals($this->document['title'], 'Random Title');
        $this->assertEquals($this->document['category'], 'just another category');
        $this->assertFalse(isset($this->document['layout']));
        $this->assertEquals($this->document->getContent(), 'Lorem Ipsum dol sidur.....Lorem Ipsum.....');
    
    }

    function testInheritAllByReplacing()
    {
        $parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
        $this->document->inherit($parent, Document::INHERIT_ALL_REPLACE);
        $this->assertEquals($this->document['title'], 'Random Title');
        $this->assertEquals($this->document['category'], 'just another category');
        $this->assertEquals($this->document['layout'], 'grid');
        $this->assertEquals($this->document->getContent(), 'Lorem Ipsum dol sidur.....');
    
    }

    function testInheritAllByAppending()
    {
        $parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
        $this->document->inherit($parent, Document::INHERIT_ALL_APPEND);
        $this->assertEquals($this->document['title'], 'Random Title');
        $this->assertEquals($this->document['category'], 'just another category');
        $this->assertEquals($this->document['layout'], 'grid');
        $this->assertEquals($this->document->getContent(), 'Lorem Ipsum dol sidur.....Lorem Ipsum.....');
    
    }

    function testIterator(){
        $params = ['title'=> 'Random Title', 'category' => 'just another category'];
        $count = 0;
        foreach ($this->document as $key => $value) {
            $this->assertEquals($params[$key], $value);
            ++$count;
        }
        $this->assertEquals($count, count($params));
    }
}
