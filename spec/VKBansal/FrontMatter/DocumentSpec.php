<?php

namespace spec\VKBansal\FrontMatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use VKBansal\FrontMatter\Document;

class DocumentSpec extends ObjectBehavior{

    function let() {
        $this->beConstructedWith('Lorem Ipsum.....', ['title'=> 'Random Title', 'category' => 'just another category']);
    }

    function it_should_get_content() {
        $this->getContent()->shouldReturn('Lorem Ipsum.....');
    }

    function it_should_set_content() {
        $this->setContent('Lorem ipsum');
        $this->getContent()->shouldReturn('Lorem ipsum');
    }

    function it_should_get_config() {
        $this->getConfig()->shouldReturn(['title'=> 'Random Title', 'category' => 'just another category']);
        $this->getConfig('title')->shouldReturn('Random Title');
    }

    function it_should_set_config() {
        $this->setConfig('title', 'Random Post Title');
        $this->getConfig('title')->shouldReturn('Random Post Title');

        $this->setConfig(['title'=> 'Random Title', 'category' => 'yet another category']);
        $this->getConfig()->shouldReturn(['title'=> 'Random Title', 'category' => 'yet another category']);
    }

    function it_should_allow_array_access() {
        $this->shouldImplement('ArrayAccess');
        $this['title']->shouldBe('Random Title');
        
        $this['title'] = 'Title';
        $this['title']->shouldBe('Title');

        unset($this['title']);

        $this->shouldNotHaveKey('title');
    }

    function it_should_allow_property_access() {
        $this->title->shouldBe('Random Title');
        
        $this->title = 'Title';
        $this->title->shouldBe('Title');

        unset($this['title']);

        $this->shouldNotHaveKey('title');
    }

    function it_should_merge_only_config() {
    
        $newDoc = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'qwerty']);
        $this->merge($newDoc);
        $this['title']->shouldBe('Not A Random Title');
        $this['layout']->shouldBe('qwerty');
        $this['category']->shouldBe('just another category');
        $this->getContent()->shouldReturn('Lorem Ipsum.....');
    
    }

    function it_should_merge_content_by_replacing() {
    
        $newDoc = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'someIndex' => 'qwerty']);
        $this->merge($newDoc, Document::MERGE_CONTENT_REPLACE);
        $this['title']->shouldBe('Random Title');
        $this['category']->shouldBe('just another category');
        $this->shouldNotHaveKey('someIndex');
        $this->getContent()->shouldReturn('Lorem Ipsum dol sidur.....');

    }

    function it_should_merge_content_by_appending() {
    
        $newDoc = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'someIndex' => 'qwerty']);
        $this->merge($newDoc, Document::MERGE_CONTENT_APPEND);
        $this['title']->shouldBe('Random Title');
        $this['category']->shouldBe('just another category');
        $this->shouldNotHaveKey('someIndex');
        $this->getContent()->shouldReturn('Lorem Ipsum.....Lorem Ipsum dol sidur.....');
    
    }

    function it_should_merge_all_by_replacing() {
    
        $newDoc = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'someIndex' => 'qwerty']);
        $this->merge($newDoc, Document::MERGE_ALL_REPLACE);
        $this['title']->shouldBe('Not A Random Title');
        $this['someIndex']->shouldBe('qwerty');
        $this['category']->shouldBe('just another category');
        $this->getContent()->shouldReturn('Lorem Ipsum dol sidur.....');
    
    }

    function it_should_merge_all_by_appending() {
    
        $newDoc = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'someIndex' => 'qwerty']);
        $this->merge($newDoc, Document::MERGE_ALL_APPEND);
        $this['title']->shouldBe('Not A Random Title');
        $this['someIndex']->shouldBe('qwerty');
        $this['category']->shouldBe('just another category');
        $this->getContent()->shouldReturn('Lorem Ipsum.....Lorem Ipsum dol sidur.....');
    }

    function it_should_inherit_only_config() {
    
        $parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
        $this->inherit($parent);
        $this['title']->shouldBe('Random Title');
        $this['category']->shouldBe('just another category');
        $this['layout']->shouldBe('grid');
        $this->getContent()->shouldReturn('Lorem Ipsum.....');
    
    }

    function it_should_inherit_content_by_replacing() {
    
        $parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
        $this->inherit($parent, Document::INHERIT_CONTENT_REPLACE);
        $this['title']->shouldBe('Random Title');
        $this['category']->shouldBe('just another category');
        $this->shouldNotHaveKey('layout');
        $this->getContent()->shouldReturn('Lorem Ipsum dol sidur.....');

    }

    function it_should_inherit_content_by_appending() {
    
        $parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
        $this->inherit($parent, Document::INHERIT_CONTENT_APPEND);
        $this['title']->shouldBe('Random Title');
        $this['category']->shouldBe('just another category');
        $this->shouldNotHaveKey('layout');
        $this->getContent()->shouldReturn('Lorem Ipsum dol sidur.....Lorem Ipsum.....');
    
    }

    function it_should_inherit_all_by_replacing() {
    
        $parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
        $this->inherit($parent, Document::INHERIT_ALL_REPLACE);
        $this['title']->shouldBe('Random Title');
        $this['category']->shouldBe('just another category');
        $this['layout']->shouldBe('grid');
        $this->getContent()->shouldReturn('Lorem Ipsum dol sidur.....');
    
    }

    function it_should_inherit_all_by_appending() {
    
        $parent = new Document('Lorem Ipsum dol sidur.....', ['title'=> 'Not A Random Title', 'layout' => 'grid']);
        $this->inherit($parent, Document::INHERIT_ALL_APPEND);
        $this['title']->shouldBe('Random Title');
        $this['category']->shouldBe('just another category');
        $this['layout']->shouldBe('grid');
        $this->getContent()->shouldReturn('Lorem Ipsum dol sidur.....Lorem Ipsum.....');
    
    }

    public function getMatchers() {
        return [
            'beSet' => function($subject) {
                return isset($subject);
            }
        ];
    }

}
