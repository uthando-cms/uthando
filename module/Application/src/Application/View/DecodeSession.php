<?php
namespace Application\View;

use Zend\View\Helper\AbstractHelper;
use Zend\Debug\Debug;

class DecodeSession extends AbstractHelper
{
    const SESSION_DELIM = '|';
    
    public function __invoke($sessionData)
    {
        $array = $this->unserialize($sessionData);
        $html = Debug::dump($array, 'Session Data:', false);
        
        return $html;
    }
    
    private function unserialize($sessionData, $startIndex=0, &$dict=null) {
        isset($dict) or $dict = array();
    
        $nameEnd = strpos($sessionData, self::SESSION_DELIM, $startIndex);
    
        if ($nameEnd !== FALSE) {
            $name = substr($sessionData, $startIndex, $nameEnd - $startIndex);
            $rest = substr($sessionData, $nameEnd + 1);
    
            $value = unserialize($rest);      // PHP will unserialize up to "|" delimiter.
            $dict[$name] = $value;
    
            return $this->unserialize($sessionData, $nameEnd + 1 + strlen(serialize($value)), $dict);
        }
    
        return $dict;
    }
}
