<?php

declare(strict_types=1);

namespace common\Helpers;

use yii\base\Model;
use yii\helpers\ArrayHelper;

abstract class AbstractForm extends Model
{
    private $forms = [];

    abstract protected function internalForms(): array;

    public function load($data, $formName = null): bool
    {
        $success = parent::load($data, $formName);
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                $success = Model::loadMultiple($form, $data, $formName === null ? null : $name) && $success;
            } else {
                $success = $form->load($data, $formName !== '' ? null : $name) && $success;
            }
        }
        return $success;
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        $parentNames = $attributeNames !== null ? array_filter((array)$attributeNames, 'is_string') : null;
        $success = parent::validate($parentNames, $clearErrors);
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                $success = Model::validateMultiple($form) && $success;
            } else {
                $innerNames = $attributeNames !== null ? ArrayHelper::getValue($attributeNames, $name) : null;
                $success = Model::validate($innerNames ?: null, $clearErrors) && $success;
            }
        }
        return $success;
    }

    public function __get($name)
    {
        if (isset($this->forms[$name])) {
            return $this->forms[$name];
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->internalForms(), true)) {
            $this->forms[$name] = $value;
        } else {
            return parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        return isset($this->forms[$name]) || parent::__isset($name);
    }
}