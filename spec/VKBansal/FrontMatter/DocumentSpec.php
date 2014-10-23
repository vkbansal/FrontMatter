<?php

namespace spec\VKBansal\FrontMatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DocumentSpec extends ObjectBehavior{

    function let(){
        $this->beConstructedWith('Lorem Ipsum.....', ['title'=> 'Random Title', 'category' => 'just another category']);
    }

    function it_should_get_content(){
        $this->getContent()->shouldReturn('Lorem Ipsum.....');
    }

    function it_should_set_content(){
        $this->setContent('Lorem ipsum');
        $this->getContent()->shouldReturn('Lorem ipsum');
    }

    function it_should_get_config(){
        $this->getConfig()->shouldReturn(['title'=> 'Random Title', 'category' => 'just another category']);
        $this->getConfig('title')->shouldReturn('Random Title');
    }

    function it_should_set_config(){
        $this->setConfig('title', 'Random Post Title');
        $this->getConfig('title')->shouldReturn('Random Post Title');

        $this->setConfig(['title'=> 'Random Title', 'category' => 'yet another category']);
        $this->getConfig()->shouldReturn(['title'=> 'Random Title', 'category' => 'yet another category']);
    }

    function it_should_allow_array_access(){
        $this->shouldImplement('ArrayAccess');
        $this['title']->shouldBe('Random Title');
        
        $this['title'] = 'Title';
        $this['title']->shouldBe('Title');

        unset($this['title']);

        $this->shouldNotHaveKey('title');
    }

    function it_should_allow_property_access(){
        $this->title->shouldBe('Random Title');
        
        $this->title = 'Title';
        $this->title->shouldBe('Title');

        unset($this['title']);

        $this->shouldNotHaveKey('title');
    }

    public function getMatchers()
    {
        return [
            'beSet' => function($subject) {
                return isset($subject);
            }
        ];
    }

}
