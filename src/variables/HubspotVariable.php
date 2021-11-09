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
                return "https://api.hubapi.com" . $partial . "?hapikey=" . $apiKey . "&state=PUBLISHED";
            }
        /* End Create the request url */
        
        /* Get Portal Id */
            public static function getPortalId(){
                try{
                    $response = HubspotVariable::client()->request('GET', HubspotVariable::makeUrl("/cos-domains/v1/domains"));
                    $response = json_decode($response->getBody());
                    return $response->objects[0]->portalId;
                }
                catch(\Exception $e)
                {
                    return false;
                }
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
            $response = HubspotVariable::client()->request('GET', HubspotVariable::makeUrl("/forms/v2/forms"));
            return $response = json_decode($response->getBody());
        }
        catch( \Exception $e )
        {
            return [];
        }
     }



}
