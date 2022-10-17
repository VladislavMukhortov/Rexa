<?php

namespace App\Enums;

class ClientEnum
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_NONE = 'none';
    const GENDER_LIST = [
        self::GENDER_FEMALE, self::GENDER_MALE
    ];
}
