<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute должен быть принят.',
    'active_url' => ':attribute не действительный URL.',
    'after' => ':attribute должна быть дата после :date.',
    'after_or_equal' => ':attribute должен быть датой после или равной :date.',
    'alpha' => ':attribute должны содержаться только буквы.',
    'alpha_dash' => ':attribute должен содержать только буквы, цифры, дефисы и символы подчеркивания.',
    'alpha_num' => ':attribute должен содержать только буквы и цифры.',
    'array' => ':attribute должен быть массив.',
    'before' => ':attribute должно быть раньше :date.',
    'before_or_equal' => ':attribute должно быть датой до или равной :date.',
    'between' => [
        'numeric' => ':attribute должно быть между :min и :max.',
        'file' => ':attribute должно быть между :min и :max килобайт.',
        'string' => ':attribute должно быть между :min и :max символов.',
        'array' => ':attribute должно быть между :min и :max предметов.',
    ],
    'boolean' => ':attribute поле должно быть истинным или ложным.',
    'confirmed' => ':attribute подтверждение не совпадает.',
    'date' => ':attribute не действительная дата.',
    'date_equals' => ':attribute должна быть дата, равная :date.',
    'date_format' => ':attribute не соответствует формату :format.',
    'different' => ':attribute и :other должны быть разными.',
    'digits' => ':attribute должны быть :digits цифры.',
    'digits_between' => ':attribute должно быть между :min и :max цифрой.',
    'dimensions' => ':attribute имеет недопустимые размеры изображения.',
    'distinct' => ':attribute поле имеет повторяющееся значение.',
    'email' => ':attribute адрес эл. почты должен быть действительным.',
    'ends_with' => ':attribute должен заканчиваться одним из следующих: :values.',
    'exists' => 'Избранные :attribute является недействительным.',
    'file' => ':attribute должен быть файл.',
    'filled' => ':attribute поле должно иметь значение.',
    'gt' => [
        'numeric' => ':attribute должно быть больше, чем :value.',
        'file' => ':attribute должно быть больше чем :value килобайт.',
        'string' => ':attribute должно быть больше чем :value символов.',
        'array' => ':attribute должно быть больше, чем :value предметов.',
    ],
    'gte' => [
        'numeric' => ':attribute должно быть больше или равно :value.',
        'file' => ':attribute должно быть больше или равно :value килобайт.',
        'string' => ':attribute должно быть больше или равно :value символов.',
        'array' => ':attribute должно быть :value символов или предметов.',
    ],
    'image' => ':attribute должно быть изображение.',
    'in' => 'Избранные :attribute является недействительным.',
    'in_array' => ':attribute поле не существует в :other.',
    'integer' => ':attribute должно быть целым числом.',
    'ip' => 'The :attribute должен быть действующий IP-адрес.',
    'ipv4' => 'The :attribute должен быть действующий IPv4-адрес.',
    'ipv6' => 'The :attribute должен быть действующий IPv6-адрес.',
    'json' => 'The :attribute должна быть действительной строкой JSON.',
    'lt' => [
        'numeric' => ':attribute должно быть меньше чем :value.',
        'file' => ':attribute должно быть меньше чем :value килобайт.',
        'string' => ':attribute должно быть меньше чем :value символов.',
        'array' => ':attribute должно быть меньше чем :value предметов.',
    ],
    'lte' => [
        'numeric' => ':attribute должно быть меньше или равно :value.',
        'file' => ':attribute должно быть меньше или равно :value килобайт.',
        'string' => ':attribute должно быть меньше или равно :value символов.',
        'array' => ':attribute не должно быть больше, чем :value предметов.',
    ],
    'max' => [
        'numeric' => ':attribute не должно быть больше, чем :max.',
        'file' => ':attribute не должно быть больше, чем :max килобайт.',
        'string' => ':attribute не должен быть больше :max символов.',
        'array' => ':attribute не должно быть больше, чем :max предметов.',
    ],

    'mimes' => ':attribute должен быть файл типа: :values.',
    'mimetypes' => ':attribute должен быть файл типа: :values.',
    'min' => [
        'numeric' => ':attribute должно быть не менее :min.',
        'file' => ':attribute должен быть не менее :min килобайт.',
        'string' => ':attribute должен быть не менее :min символов.',
        'array' => ':attribute должен быть не менее :min предметов.',
    ],
    'multiple_of' => ':attribute должно быть кратно :value.',
    'not_in' => 'Избранные :attribute является недействительным.',
    'not_regex' => ':attribute формат недействителен.',
    'numeric' => ':attribute должен быть числом.',
    'password' => 'Пароль неверен.',
    'present' => ':attribute поле должно присутствовать.',
    'regex' => ':attribute формат недействителен.',
    'required' => ':attribute поле, обязательное для заполнения.',
    'required_if' => ':attribute поле обязательно, когда :other есть :value.',
    'required_unless' => ':attribute поле является обязательным, если только :other в :values.',
    'required_with' => ':attribute поле обязательно, когда :values настоящее.',
    'required_with_all' => ':attribute поле обязательно, когда :values присутствуют.',
    'required_without' => ':attribute поле обязательно, когда :values нет.',
    'required_without_all' => ':attribute поле является обязательным, если ни один из :values присутствуют.',
    'prohibited' => ':attribute поле запрещено.',
    'prohibited_if' => ':attribute поле запрещено, когда :other есть :value.',
    'prohibited_unless' => ':attribute поле запрещено, если :other в :values.',
    'same' => ':attribute и :other должен соответствовать.',
    'size' => [
        'numeric' => ':attribute должно быть :size.',
        'file' => ':attribute должно быть :size килобайт.',
        'string' => ':attribute должно быть :size символов.',
        'array' => ':attribute должен содержать :size предметов.',
    ],
    'starts_with' => ':attribute должен начинаться с одного из следующих: :values.',
    'string' => ':attribute должна быть строка.',
    'timezone' => ':attribute должна быть действующая зона.',
    'unique' => ':attribute уже используется',
    'uploaded' => ':attribute не удалось загрузить.',
    'url' => ':attribute формат недействителен.',
    'uuid' => ':attribute должен быть действительный UUID.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'balance_client' => [
            'min' => 'Недостаточно средств',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [

    ],

];
