<?php
namespace jordanbeattie\hubspot\models;

use Craft;

class Settings extends \craft\base\Model
{
    public $hsApiKey, $hsPortalId;
    
    public function rules(): array
    {
        return [
            [
                ['hsApiKey', 'hsPortalId'], 'required'
            ]
        ];
    }
    
    public function getHsApiKey(): ?string
    {
        return Craft::parseEnv($this->hsApiKey);
    }
    
    public function getHsPortalId(): ?string
    {
        return Craft::parseEnv($this->hsPortalId);
    }
    
}
