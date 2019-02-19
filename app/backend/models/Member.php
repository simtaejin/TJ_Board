<?php

namespace Multiple\Backend\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Regex as RegexValidator;
use Phalcon\Validation\Validator\PresenceOf as PresenceOf;
use Phalcon\Security as Security;

class Member extends ModelBase
{
    public $idx;
    public $id;
    public $password;
    public $email;
    public $role;
    public $created;
    public $updated;
    public $login;

    public function initialize()
    {
        $this->setSchema("tj_board");
        $this->setSource("member");

        $this->allowEmptyStringValues(['id', 'password', 'email']);
//        $this->skipAttributes(['id', 'password', 'email']);

    }

    public function getSource()
    {
        return 'member';
    }

    public function beforeValidationOnCreate()
    {
        $this->created = date('Y-m-d H:i:s');

        if ($this->password) {
            $security = new Security();
            $this->password = $security->hash($this->password);
        }
    }

    public function beforeValidationOnUpdate()
    {
        $this->updated = date('Y-m-d H:i:s');

        if ($this->password) {
            $security = new Security();
            $this->password = $security->hash($this->password);
        }
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(['id', 'password', 'email'], new PresenceOf([
            'message' => [
                'id' => 'ID를 입력하세요.',
                'password' => 'Password를 입력하세요.',
                'email' => 'Email을 입력하세요.'
            ],
        ]));

        $validator->add('id', new RegexValidator(['pattern' => '/[a-zA-Z0-9]*/', 'message' => 'ID는 영문으로 입력하세요.',]));

        $validator->add('email', new EmailValidator(['message' => 'Email 형식으로 입력하세요.',]));

        return $this->validate($validator);
    }
}
