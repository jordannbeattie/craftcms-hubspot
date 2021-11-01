<?php
/**
 * hubspot plugin for Craft CMS 3.x
 *
 * Hubspot integration with craftcms
 *
 * @link      jordanbeattie.com
 * @copyright Copyright (c) 2018 Jordan Beattie
 */

namespace jordanbeattie\hubspot\services;

use jordanbeattie\hubspot\Hubspot;

use Craft;
use craft\base\Component;

/**
 * Frhubspotservice Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Jordan Beattie
 * @package   Frhubspot
 * @since     1.0.0
 */
class Hubspotservice extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     Frhubspot::$plugin->hubspotservice->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';

        return $result;
    }
}
