<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Szopen\ContactDataExtractor;

use Szopen\ContactDataExtractor\Contact\ExtractedEmail;
use Szopen\ContactDataExtractor\Contact\ExtractedTelephone;

/**
 * Description of TelephoneExtractor
 *
 * @author leandro.luccerini
 */
class ContactDataExtractor {

    /**
     * Espressione regolare per cercare i numeri mobili
     */
    const REGEX_MOBILE = '/\b(?!0)\d{3}[-.\/ ]*\d{3}[-.\/]?\d{4}\b/';

    /**
     * Espressione regolare per cercare i numeri fissi
     */
    const REGEX_FIX = '/\b0+\d{1,4}[-.\/ ]*\d{6,8}\b/';
    
    /**
     * Espressione regolare per cercare le email
     * URL di riferimento http://emailregex.com/
     */
    const REGEX_EMAIL = '/\b(?:[a-z0-9!#$%&\'\*\+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'\*\+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])\b/i';

    /**
     * Estrae tutti i numeri di telefono
     * 
     * @param string $field
     * @return array
     */
    public static function extractAllTelephoneNumbers(string $field = null): array {

        $telephones = [];

        $mobile = self::extractMobileNumbers($field);
        $fix = self::extractMobileNumbers($field);

        return array_merge($mobile, $fix);
    }

    /**
     * Estrae tutti i numeri di telefono mobili della stringa field
     * 
     * @param string $field
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function extractMobileNumbers(string $field = null): array {
        return self::extraction(self::REGEX_MOBILE, ExtractedTelephone::TYPE_MOBILE, $field);
    }

    /**
     * Estrae tutti i numeri fissi della stringa field
     * 
     * @param string $field
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function extractFixNumbers(string $field = null): array {
        return self::extraction(self::REGEX_FIX, ExtractedTelephone::TYPE_FIX, $field);
    }
    
    /**
     * Estrae tuttle email dala stringa field
     * 
     * @param string $field
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function extractEmailAddresses(string $field = null): array {
        return self::extraction(self::REGEX_EMAIL, ExtractedEmail::TYPE_EMAIL, $field);
    }

    /**
     * Estrae tutti i numeri di telefono in base ai parametri passati
     * 
     * @param string $regex
     * @param string $type
     * @param string $field
     * @return array
     */
    private static function extraction(string $regex, string $type, string $field = null): array {

        // Imposta l'array dei valori estratti
        $matches = null;
        $elements = [];
        
        if(empty($field)){
            return $elements;
        }

        // Estrae i valori base all'espressione regolare passata
        if (preg_match_all($regex, $field, $matches)) {
            // Aggiunge l'array di numeri cellulari
            foreach ($matches[0] as $element) {
                
                switch ($type){
                    
                    case ExtractedEmail::TYPE_EMAIL:
                        try{
                            $elements[] = new ExtractedEmail($element);
                        } catch (\InvalidArgumentException $e){
                            null;
                        }
                        break;
                    
                    default:
                        $elements[] = new ExtractedTelephone($element, $type);
                        break;
                    
                }
                
            }
        }

        return $elements;
    }

}
