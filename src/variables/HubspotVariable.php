<?php

namespace jordanbeattie\hubspot\variables;

use jordanbeattie\hubspot\Hubspot;
use GuzzleHttp;

use Craft;

class HubspotVariable
{

	/* Helper functions */
    
            /* HTTP Client */
                public static function client()
                {
                    return new GuzzleHttp\Client();
                }
            /* End HTTP Client */

			/* Create the request url */
                public static function makeUrl($partial){
                    $apiKey = \jordanbeattie\hubspot\Hubspot::getInstance()->settings->hsApiKey;
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
                public static function hasApiKey()
                {
                    return \jordanbeattie\hubspot\Hubspot::getInstance()->settings->hsApiKey ? true : false;
                }
            /* End Check Api Key Is Set */
    
            /* Check plugin can be used */
                public function isUseable()
                {
                    return HubspotVariable::hasApiKey() && HubspotVariable::getPortalId();
                }
            /* End Check plugin can be used */

	/* Forms */

			/* Get list of forms */
			public static function getForms(){
				$partial = "/forms/v2/forms";
	            $requestUrl = HubspotVariable::makeUrl($partial);
				$response = file_get_contents($requestUrl);
				$responseDecoded = json_decode($response);
				return $responseDecoded;
			}

			/* Get specific form */
			public static function getForm($guid){
				$partial = "/forms/v2/forms/" . $guid;
	            $requestUrl = HubspotVariable::makeUrl($partial);
				$response = file_get_contents($requestUrl);
				$responseDecoded = json_decode($response);
				return $responseDecoded;
			}



}
