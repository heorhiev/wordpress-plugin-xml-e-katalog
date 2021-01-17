<?php
/**
 * Класс генерирует XML для E-Katalog от WOO
 *
 * @package EKatWoo
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */

namespace EKatWoo\Services;

use DOMImplementation;
use EKatWoo\Repositories\Settings;
use EKatWoo\Repositories\WooCatalog;


class WooGeneratorXML extends GeneratorXML {

    /**
     * Метод генерирования xml
     */
    public function __construct() {   
        $this->setHeader();
        $this->setCurrencies();
        $this->setCategories();
        $this->setOffers();

        $this->saveToFile(Settings::getXmlFileDir());
    }

        
    /**
     * Метод устанавливает шапку
     */    
    private  function setHeader() {
        $implementation = new DOMImplementation();     
        $dtd = $implementation->createDocumentType('yml_catalog', '', 'shops.dtd');    
                        
        $this->dom = $implementation->createDocument('', '', $dtd);        
        $this->dom->encoding = 'utf-8';  
        
        $ymlCatalog = $this->addElement($this->dom, 'yml_catalog', '', [
            'date' => current_time('Y-m-d H:i'),
        ]); 

        $this->catalog = $this->addElement($ymlCatalog, 'shop');
        $this->addElement($this->catalog, 'name', Settings::getName());
        $this->addElement($this->catalog, 'url', Settings::getUrl());
    }

    
    /**
     * Метод устанавливает валюты
     */    
    private  function setCurrencies() {
        $currencies = $this->addElement($this->catalog, 'currencies');
        
        $this->addElement($currencies, 'currency', '', [
            'id'   => Settings::getCurrency(),   
            'rate' => 1,
        ]);  
    }

    
    /**
     * Метод устанавливает категории
     */     
    private  function setCategories() {
        $terms = WooCatalog::getTerms([
            'exclude' => Settings::getExcludeCategories(),
        ]);

        if (!$terms) {
            return;
        }

        $categories = $this->addElement($this->catalog, 'categories');        
        
        foreach ($terms as $term) { 
            $this->addElement($categories, 'category', $term->name, [
                'id'        => $term->term_id,
                'parentId'  => $term->parent,
            ]);
        }
    }
    
    
    /**
     * Метод устанавливает товары
     */     
    private  function setOffers() {
        $products = WooCatalog::getProducts([
            'exclude_category' => Settings::getExcludeCategories(),
        ]);

        if (!$products) {
            return $products;
        }

        $offers = $this->addElement($this->catalog, 'offers');

        foreach ($products as $product) {

            $offer = $this->addElement($offers, 'offer', '', [
                'id' => $product->get_id(),
            ]);

            $this->addElement($offer, 'name',  $product->get_title()); 
            $this->addElement($offer, 'url',   $product->get_permalink()); 
            $this->addElement($offer, 'price', $product->get_price());            
            $this->addElement($offer, 'image', get_the_post_thumbnail_url($product->get_id()));

            // описание
            switch (Settings::getDescParam()) {
                case 'short':
                    $description = $product->get_short_description();
                    break;
                case 'full':
                    $description = $product->get_description();
                    break;
                default:
                    $description = $product->get_short_description();
                    
                    if (!$description) {
                        $description = $product->get_description();
                    }
            }

            $this->addElement($offer, 'description', $description);
            
            if ($cats = $product->get_category_ids()) {
                $this->addElement($offer, 'categoryId', $cats[0]);
            }        
        }
    }
}