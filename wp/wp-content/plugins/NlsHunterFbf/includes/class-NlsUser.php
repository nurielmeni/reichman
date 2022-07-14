<?php

class NlsUser
{
    public $userId;
    public $cardId;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $israeliId;
    private $model;

    public function __construct($model, $config = [])
    {
        $this->model = $model;
        foreach ($config as $key => $value) {
            if (property_exists(self::class, $key)) {
                $this->$key = $value;
            }
        }
        $this->getUserByUserId();
    }

    public function getFullName()
    {
        return $this->firstName . ($this->lastName ? ' ' . $this->lastName : '');
    }

    private function getUserByUserId()
    {
        if (!$this->userId) return false;
        $res = $this->model->userGetById($this->userId);

        if (!$res) return false;

        $this->cardId = property_exists($res, 'CardId') ? $res->CardId : '';
        $this->firstName = property_exists($res, 'FirstName') ? $res->FirstName : '';
        $this->lastName = property_exists($res, 'LastName') ? $res->LastName : '';
        $this->email = property_exists($res, 'Email') ? $res->Email : '';
        //$this->cardId = property_exists($res, 'CardId') ? $res->CardId : '';
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this->getUserByUserId($userId);
    }
}
