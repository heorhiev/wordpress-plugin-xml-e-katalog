<?php
/**
 * Класс генерирует XML
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace EKatWoo\Services;


class GeneratorXML {
    public $queryCondition;
    
    protected $dom;
    protected $catalog;


    public function __construct() {
        $this->dom     = null;
        $this->catalog = null;
    }

    
    /**
     * Метод возвращает документ
     */       
    protected function getDocument() {    
        return $this->dom->saveXML();
    }


    /**
     * Метод сохранения xml
     */
    protected function saveToFile($path) {
        file_put_contents(
            $path, 
            $this->getDocument()
        );
    }

    
    /**
     * Метод конвертирования первого символа в верних регистр
     */
    protected function ucFirst($text) {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }

            
    /**
     * Метод создания элемента
     */     
    protected function addElement($element, $createElement, $text = '', $attributes = array(), $cData = false) {
        $element = $element->appendChild($this->dom->createElement($createElement));
        
        if ($attributes) {
            foreach ($attributes as $key => $attribute) {
                if ($attribute or is_string($attribute)) {
                    $element->setAttribute($key, trim($attribute));    
                }
            }
        }
        
        if ($text != '' || $text == 0) {
            $text = $cData ? '<![CDATA[' . $text . ']]>' : htmlspecialchars(strip_tags($text));            
            $element->appendChild($this->dom->createTextNode(trim($text)));
        }   
        
        return $element;      
    }       
}