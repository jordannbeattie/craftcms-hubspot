<?php
namespace jordanbeattie\hubspot\models;

use Craft;

class Settings extends \craft\base\Model
{
    public $hsApiKey;
    
    public function rules(): array
    {
        return [
            [['hsApiKey'], 'required']
        ];
    }
    
    public function getHsApiKey(): string
    {
        return Craft::parseEnv($this->hsApiKey);
    }
    
}
