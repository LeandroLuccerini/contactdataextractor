<?php
namespace Szopen\ContactDataExtractor\Contact;

/**
 * Description of ExtractedTelephone
 *
 * @author leandro.luccerini
 */
class ExtractedTelephone {
    
    /**
     * Tipo di numero di telefono "Mobile"
     */
    const TYPE_MOBILE = 'mobile';
    
    /**
     * Tipo di numero di telefono "Fisso"
     */
    const TYPE_FIX = 'fix';
    
    /**
     *
     * @var string 
     */
    private $telephone;
    
    /**
     *
     * @var string 
     */
    private $type;

    /**
     *
     * @param string $phone
     * @param string $type
     */
    public function __construct(string $phone, string $type) {
        
        // Utilizzato per check del tipo
        $types = [self::TYPE_FIX, self::TYPE_MOBILE];
        // Imposta il numero di telefono pulendolo di diversi elementi impuri
        $this->telephone = str_replace(['/', '.', '-', ' '], '', $phone);
        
        // Non è un tipo valido
        if(!in_array($type, $types)){
            throw new \InvalidArgumentException("Il tipo '$type' non è valido, accettati: ".self::TYPE_MOBILE." per il mobile e ".self::TYPE_FIX." per il fisso.");
        }
        
        $this->type = $type;
    }
    
    /**
     * 
     * @return string
     */
    public function getTelephoneNumber() : string{
        return $this->telephone;
    }

    /**
     *
     * @return ExtractedTelephone
     */
    public function setAsMobile() : ExtractedTelephone{
        $this->type = self::TYPE_MOBILE;
        
        return $this;
    }

    /**
     *
     * @return ExtractedTelephone
     */
    public function setAsFix() : ExtractedTelephone{
        $this->type = self::TYPE_FIX;
        
        return $this;
    }
    
    /**
     * 
     * @return bool
     */
    public function isMobile() : bool{
        return $this->type === self::TYPE_MOBILE;
    }
    
    /**
     * 
     * @return bool
     */
    public function isFix() : bool{
        return $this->type === self::TYPE_FIX;
    }
    
    
}