<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

class XmlParserComponent extends Component
{
    public function parsArray(array $dataToParse)
    {
        $ret = '';

        foreach($dataToParse as $key => $value) {
            $escapedKey = $this->escapeKey($key);
            $ret .= "<$escapedKey>,,,,</$escapedKey>";
        }

        dd($ret);
    }

    private function escapeKey(string $key)
    {
        return str_replace(' ','_',$key);
    }

    public function repeat(string $textForRepeat, int $numberOfRepeat)
    {

        if($numberOfRepeat == 1) {
            return $textForRepeat;
        } else {
            return $textForRepeat . $this->repeat($textForRepeat, $numberOfRepeat - 1);
        }
    }

    public function test(array $dataToParse, bool $attachHeader = true)
    {
        $temp = '';
        foreach($dataToParse as $parent => $child) {
            $value = $child;

            if(is_array($child)) {
                if(array_key_exists('_cdata', $child)) {
                    $value = '<![CDATA[' . $child['_cdata'] . ']]>';
                } else {
                    $value = $this->test($child, false);
                }
            }

            $escapedKey = $this->escapeKey($parent);
            $temp .= "<$escapedKey>$value</$escapedKey>";

        }
        if($attachHeader){
            $output = '<?xml version="1.0"?>';
            $output .= '<root>';
            $output .= $temp;
            $output .= '</root>';

            return $output;
        }

        return $temp;
    }
}