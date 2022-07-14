<?php

class NlsBoardItem
{
    public $name;
    public $list;
    public $label;
    public $count;
    public $modalToggle;
    public $image;

    public function __construct($name, $list, $label, $count, $modalToggle = null, $image = '')
    {
        $this->name = is_string($name) ? preg_replace('/[ ,:]+/', '-', trim($name)) : '';
        $this->list = is_array($list) ? $list : [];
        $this->label = is_string($label) ? $label : '';
        $this->count = is_int($count) ? $count : count($this->list);
        $this->modalToggle = $modalToggle;
        $this->image = is_string($image) && !empty($image) ? $image : NLS__PLUGIN_URL . '/public/images/personal/matched.svg';
    }
}
class NlsUser
{
    public $userId;

    public $cardId;
    public $firstName;
    public $lastName;
    public $fullName;
    public $email;
    public $phone;
    public $userName;

    public $appliedJobs;
    public $cvList;
    public $fileList;
    public $agentJobs;
    public $myAreaJobs;

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

        $res = $this->model->getUserIdByCardId('C57986DC-1665-44B3-B84B-77929A046035');

        $this->getUserCvList();
        $this->getUserFileList();
        $this->getUserAppliedJobs();
        $this->getUserAgentJobs();
        $this->getUserMyAreaJobs();
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

        $this->cardId = property_exists($res, 'CardId') && $res->CardId ? $res->CardId : false;
        $this->firstName = property_exists($res, 'FirstName') && $res->FirstName ? $res->FirstName : '';
        $this->lastName = property_exists($res, 'LastName') && $res->LastName ? $res->LastName : '';
        $this->fullName = $this->firstName . ' ' . $this->lastName;
        $this->email = property_exists($res, 'Email') && $res->Email ? $res->Email : '';
        $this->userName = property_exists($res, 'UserName') && $res->UserName ? $res->UserName : '';
        $this->phone = $this->getUserPhone($res);
    }

    private function getUserPhone($user)
    {
        if (!property_exists($user, 'Phones') || !property_exists($user->Phones, 'PhoneInfo')) return '';
        return $user->Phones->PhoneInfo->AreaCode . '-' . $user->Phones->PhoneInfo->PhoneNumber;
    }

    private function getUserCvList()
    {
        $res = $this->cardId ? $this->model->getApplicantCVList($this->cardId) : (object) ['list' => [], 'totalNumResults' => 0];
        $this->cvList = new NlsBoardItem('cv-list', $res->list, 'My CV Files', $res->totalNumResults, 'fileManagerModal');
    }

    private function getUserFileList()
    {
        $res = $this->cardId ? $this->model->getFileList($this->cardId) : (object) ['list' => [], 'totalNumResults' => 0];
        $this->fileList = new NlsBoardItem('file-list', $res->list, 'Additional Files', $res->totalNumResults, 'fileManagerModal');
    }

    private function getUserAppliedJobs()
    {
        $this->appliedJobs = new NlsBoardItem('applied-jobs', [], 'Jobs I applied to', 0, 'fileManagerModal');
    }

    private function getUserAgentJobs()
    {
        $this->agentJobs = new NlsBoardItem('agent-jobs', [], 'Jobs by Smart Agent', 0);
    }

    private function getUserMyAreaJobs()
    {
        $this->myAreaJobs = new NlsBoardItem('my-area-jobs', [], 'Jobs by My Area', 0);
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this->getUserByUserId($userId);
    }


    public function getStatItems()
    {
        return [
            $this->appliedJobs,
            $this->cvList,
            $this->fileList,
            $this->agentJobs,
            $this->myAreaJobs,
        ];
    }
}
