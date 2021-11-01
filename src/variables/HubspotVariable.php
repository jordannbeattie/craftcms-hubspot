<?php
/**
 * hubspot plugin for Craft CMS 3.x
 *
 * Hubspot integration with craftcms
 *
 * @link      jordanbeattie.com
 * @copyright Copyright (c) 2018 Jordan Beattie
 */

namespace jordanbeattie\hubspot\variables;

use jordanbeattie\hubspot\Hubspot;

use Craft;

/**
 * hubspot Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.hubspot }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Jordan Beattie
 * @package   Frhubspot
 * @since     1.0.0
 */
class HubspotVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.hubspot.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.hubspot.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */



	/* Helper functions */

			/* Create the request url */
			public static function makeUrl($partial){
				$apiKey = getenv('HUBSPOT_API_KEY');
				return "https://api.hubapi.com" . $partial . "?hapikey=" . $apiKey . "&state=PUBLISHED";
			}

			/* Array ordering */
				/* Order an array by the hubspot date variable */
				public function orderByDate($array){
					usort($array, array($this, "compareTimes"));
					return $array;
				}
				public static function compareTimes($a, $b){
					// return strnatcmp($a->publish_date, $b->publish_date);
					if($a->publish_date == $b->publish_date){ return 0; }
					return $a->publish_date < $b->publish_date?1:-1;
				}

			/* Portal Id */
			public static function getPortalId(){
				$partial = "/cos-domains/v1/domains";
				$requestUrl = HubspotVariable::makeUrl($partial);
	      $response = file_get_contents($requestUrl);
				return json_decode($response)->objects[0]->portalId;
			}

			public static function getTrackingCode(){
			    $portalId = HubspotVariable::getPortalId();
			    return '<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/' . $portalId . '.js"></script>';
      }

	/* Blog Posts */

	    /* Get all blog posts. Optional limit, defaults to 300 (max allowed) */
	    public static function getBlogPosts($limit = 300){
	      $requestUrl = HubspotVariable::makeUrl("/content/api/v2/blog-posts") . "&limit=" . $limit;
	      $response = file_get_contents($requestUrl);
				return json_decode($response)->objects;
	    }

			/* Get info on specific blog post */
			public static function getBlogPost($postId){
				$partial = "/content/api/v2/blog-posts/" . $postId;
				$requestUrl = HubspotVariable::makeUrl($partial);
				$response = file_get_contents($requestUrl);
				return json_decode($response);
			}

			public static function getBlogPostBySlug($slug){
				$partial = "/content/api/v2/blog-posts";
				$requestUrl = HubspotVariable::makeUrl($partial);
				$requestUrl .= "&slug=" . $slug;
	      $response = file_get_contents($requestUrl);
				echo '<script> console.log("' . $requestUrl . '")</script>';
				return json_decode($response)->objects[0];
			}


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
