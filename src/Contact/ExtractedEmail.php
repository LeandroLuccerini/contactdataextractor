<?php
namespace Szopen\ContactDataExtractor\Contact;

/**
 * Description of ExtractedEmail
 *
 * @author leandro.luccerini
 */
class ExtractedEmail {
    
    const TYPE_EMAIL = 'email';
    
    /**
     *
     * @var string 
     */
    private $email;
    
    /**
     * 
     * @param string $email
     * @throws \InvalidArgumentException
     */
    public function __construct(string $email)
    {
        
        $this->email = strtolower($email);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email '.$email.' non valida') ;
        }
    }
    
    /**
     * 
     * @return string
     */
    public function getEmail() : string 
    {
        return $this->email;
    }
            
}
