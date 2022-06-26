<?php

class NlsUserCredentials
{
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;

    public function __construct($config = [])
    {
        foreach ($config as $key => $value) {
            if (property_exists(self::class, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getFullName()
    {
        return $this->firstName . ($this->lastName ? ' ' . $this->lastName : '');
    }
}
