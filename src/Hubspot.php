<?php

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
use \craft\web\View;
use craft\events\RegisterTemplateRootsEvent;

use yii\base\Event;

class Hubspot extends Plugin
{
    
    public static $plugin;
    public $schemaVersion = '1.0.0';
    public $hasCpSettings = true;
    
    public function init()
    {
        
        parent::init();
        self::$plugin = $this;
        
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $variable = $event->sender;
                $variable->set('hubspot', HubspotVariable::class);
            }
        );

        Event::on(
          Fields::class,
          Fields::EVENT_REGISTER_FIELD_TYPES,
          function (RegisterComponentTypesEvent $event) {
            $event->types[] = HubspotFormField::class;
          }
        );

        Craft::info(
            Craft::t(
                'hubspot',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    
        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['hubspot'] = __DIR__ . '/available-templates';
            }
        );
        
    }
    
    protected function createSettingsModel(){
        return new \jordanbeattie\hubspot\models\Settings();
    }

    protected function settingsHtml(){
        return \Craft::$app->getView()->renderTemplate('hubspot/settings', [
            'settings' => $this->getSettings()
        ]);
    }

}
