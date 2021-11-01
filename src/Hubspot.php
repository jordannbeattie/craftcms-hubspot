<?php
/**
 * hubspot plugin for Craft CMS 3.x
 *
 * Hubspot integration with craftcms
 *
 * @link      jordanbeattie.com
 * @copyright Copyright (c) 2018 Jordan Beattie
 */

namespace jordanbeattie\hubspot;

use jordanbeattie\hubspot\services\Hubspotservice as FrhubspotserviceService;
use jordanbeattie\hubspot\variables\HubspotVariable;
use jordanbeattie\hubspot\twigextensions\HubspotTwigExtension;
use jordanbeattie\hubspot\fields\HubspotForm as HubspotFormField;
use jordanbeattie\hubspot\fields\HubspotBlogPost as HubspotBlogPostField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Jordan Beattie
 * @package   Frhubspot
 * @since     1.0.0
 *
 * @property  FrhubspotserviceService $hubspotservice
 */
class Hubspot extends Plugin
{
    // Static Properties
    // =========================================================================

    public $hasCpSettings = true;

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * Frhubspot::$plugin
     *
     * @var Hubspot
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * Frhubspot::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register Twig extensions
        Craft::$app->view->registerTwigExtension(new HubspotTwigExtension());

        // Register variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('hubspot', HubspotVariable::class);
            }
        );

        // Register fields
        Event::on(
          Fields::class,
          Fields::EVENT_REGISTER_FIELD_TYPES,
          function (RegisterComponentTypesEvent $event) {
            $event->types[] = HubspotFormField::class;
            $event->types[] = HubspotBlogPostField::class;
          }
        );



        // Do something after installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // do something
                }
            }
        );

/**
 * Logging in Craft involves using one of the following methods:
 *
 * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
 * Craft::info(): record a message that conveys some useful information.
 * Craft::warning(): record a warning message that indicates something unexpected has happened.
 * Craft::error(): record a fatal error that should be investigated as soon as possible.
 *
 * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
 *
 * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
 * the category to the method (prefixed with the fully qualified class name) where the constant appears.
 *
 * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
 * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
 *
 * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
 */
        Craft::info(
            Craft::t(
                'hubspot',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    protected function createSettingsModel(){
      return new models\Settings();
    }

    protected function settingsHtml(){
      return \Craft::$app->getView()->renderTemplate('hubspot/settings', [
        'settings' => $this->getSettings()
      ]);
    }

}
