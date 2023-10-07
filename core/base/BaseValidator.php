<?php

namespace base;

abstract class BaseValidator
{
    protected array $fields;

    public function validate(array $data): bool
    {
        foreach ($data as $item => $value) {
            if (!array_key_exists($item, $this->fields))
                return false;

            $fieldRules = $this->fields[$item];
            if(empty($fieldRules))
                return true;
            else
                foreach ($fieldRules as $rule)
                    if (!$this->validateField($value, $rule))
                        return false;
        }

        return true;
    }

    protected function validateField(string $value, string $rule): bool
    {
        // Проверка строки
        if (str_starts_with($rule, 'string@')) {
            $maxLength = intval(substr($rule, 7)); // Получение длины строки
            if (strlen($value) > $maxLength)
                return false;
        }

        // Проверка целых чисел
        if ($rule === 'int')
            if (!ctype_digit($value))
                return false;

        return true;
    }
}