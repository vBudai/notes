<?php

namespace controllers\validators;

use base\BaseValidator;

class NoteValidator extends BaseValidator
{

    protected array $fields = [
        'id' => ['int'],
        'title' => ['string@255'],
        'text' => [],
        'bgColor' => ['string@6'],
        'textColor' => ['string@6']
    ];

}