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
    public $requestUserId;
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

        if (isset($_COOKIE['REICHMAN_USER'])) {
            $userData = unserialize(base64_decode($_COOKIE['REICHMAN_USER']));
            add_filter('nym_auth_action_label', function () {
                return __('Logout', 'NlsHunetrFbf');
            });
        } else {
            // Career Test userId = '33120', cardId = '52a6d317-48ea-42f2-931f-91c58bb1b6e1'
            if (empty($this->requestUserId) && !empty($this->cardId)) {
                $this->requestUserId = $this->model->getUserIdByCardId($this->cardId);
            }

            add_filter('nym_auth_action_label', function () {
                return __('Login', 'NlsHunetrFbf');
            });

            if (!$this->requestUserId) return false;

            $userData = $this->model->userGetById($this->requestUserId);
            setcookie('REICHMAN_USER', base64_encode(serialize($userData)), time() + 60 * 1);
            add_filter('nym_auth_action_label', function () {
                return __('Logout', 'NlsHunetrFbf');
            });
        }
        $this->mapUserData($userData);
        $this->getUserData();

        $this->mapUserData($userData);
    }

    public function logout()
    {
        unset($_COOKIE['REICHMAN_USER']);
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    public function isLoggedIn()
    {
        return !empty($this->userId);
    }

    public function getUserData()
    {
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

    private function mapUserData($userData)
    {
        if (!$userData) return false;

        $this->userId = property_exists($userData, 'UserId') && $userData->UserId ? $userData->UserId : false;
        $this->cardId = property_exists($userData, 'CardId') && $userData->CardId ? $userData->CardId : false;
        $this->firstName = property_exists($userData, 'FirstName') && $userData->FirstName ? $userData->FirstName : '';
        $this->lastName = property_exists($userData, 'LastName') && $userData->LastName ? $userData->LastName : '';
        $this->fullName = $this->firstName . ' ' . $this->lastName;
        $this->email = property_exists($userData, 'Email') && $userData->Email ? $userData->Email : '';
        $this->userName = property_exists($userData, 'UserName') && $userData->UserName ? $userData->UserName : '';
        $this->phone = $this->getUserPhone($userData);
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
