<?php
namespace jordanbeattie\hubspot\models;

class Settings extends \craft\base\Model
{
    public $hsApiKey;
    
    public function rules()
    {
        return [
            [['hsApiKey'], 'required']
        ];
    }
}
