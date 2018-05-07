<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Component\XmlParserComponent;
use Cake\Controller\ComponentRegistry;

class TestController extends AppController
{
    /** @var  XmlParserComponent */
    private $xmlParser;

    public function initialize()
    {
        parent::initialize();
        $this->xmlParser = new XmlParserComponent(new ComponentRegistry());
    }

    public function test()
    {
        $array = [
            'Good guy' => [
                'name' => 'Luke Skywalker',
                'weapon' => 'Lightsaber'
            ],
            'Bad guy' => [
                'name' => 'Sauron',
                'weapon' => 'Evil Eye'
            ]
        ];


        $array2 = [
          'books' => [
              '_attr' => ['b' => 1],
              'book' => [
                  [
                      '_attr' => ['a' => 1],
                      'author' => 'Paweł',
                      'rok wydania' => '2001'
                  ],
                  [
                      '_attr' => ['a' => 100],
                      'author' => 'Arek',
                      'rok wydania' => '2014'
                  ],
              ]
          ]
        ];

        $output = <<<XML
<books b="1">
    <book a="1">
        <author>Paweł</author>
        <year>2001</year>
    </book>
    <book a="100">
        <author>Arek</author>
        <year>2014</year>
    </book>
</books>
XML;

        $array3 = [
            'name' => [
                '_cdata' => '<h1>Luke Skywalker</h1>'
            ],
            'weapon' => 'Lightsaber'
        ];

        $array4 = [
            'name' => 'Luke Skywalker',
            'weapon' => 'Lightsaber'
        ];

        $xmlString = $this->xmlParser->test($array2);
        $doc = new \DOMDocument();
        $doc->loadXML($xmlString);

        dd($doc->save('xyz.xml'));
        die;
    }
}