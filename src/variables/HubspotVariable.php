<?php

namespace jordanbeattie\hubspot\variables;

use jordanbeattie\hubspot\Hubspot;
use GuzzleHttp;

use Craft;

class HubspotVariable
{
    
    /**** Helpers ****/
        
        /* HTTP Client */
            protected static function client()
            {
                return new GuzzleHttp\Client();
            }
        /* End HTTP Client */
        
        /* Create the request url */
            protected static function makeUrl($partial){
                $apiKey = \jordanbeattie\hubspot\Hubspot::getInstance()->settings->getHsApiKey();
                return "https://hubcraft.jordanbeattie.com/api" . $partial . "?apiKey=" . $apiKey;
            }
            /* End Create the request url */
            
            /* Get Portal Id */
            public static function getPortalId(){
                return \jordanbeattie\hubspot\Hubspot::getInstance()->settings->getHsPortalId();
            }
        /* Get Portal Id */
        
        /* Check Api Key Is Set */
            private static function hasApiKey()
            {
                return \jordanbeattie\hubspot\Hubspot::getInstance()->settings->hsApiKey ? true : false;
            }
        /* End Check Api Key Is Set */
        
        /* Check plugin can be used */
            public static function isUseable()
            {
                return HubspotVariable::hasApiKey() && HubspotVariable::getPortalId();
            }
        /* End Check plugin can be used */
    
        /* Get forms URL */
            public static function getFormsUrl()
            {
                return 'https://app.hubspot.com/forms/' . static::getPortalId();
            }
        /* End Get forms URL */
        
    /**** End Helpers ****/
    
    public static function getForms(){
        try
        {
            $forms = [];
            $response = HubspotVariable::client()->request('GET', HubspotVariable::makeUrl("/forms"));
            $response = json_decode($response->getBody());
            foreach( $response as $form )
            {
                if( property_exists($form, 'id') && property_exists($form, 'name') )
                {
                    $forms[$form->name] = $form->id;
                }
            }
            ksort($forms);
            return $forms;
        }
        catch( \Exception $e )
        {
            return [];
        }
    }
    
    public function render($form)
    {
        echo Craft::$app->view->renderTemplate('hubspot/form', [
            'form' => $form,
            'portal' => static::getHsPortalId()
        ]);
    }

}
