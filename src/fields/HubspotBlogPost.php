<?php

namespace jordanbeattie\hubspot\fields;

use jordanbeattie\hubspot\Hubspot;
use jordanbeattie\hubspot\variables\HubspotVariable;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

class HubspotBlogPost extends Field
{

    public $dropdownOptions = '';

    public static function displayName(): string
    {
        return Craft::t('hubspot', 'Hubspot Blog Post');
    }

    public function getSettingsHtml()
    {
        return false;
    }

    public function getInputHtml($value, ElementInterface $element = null): string
    {

		$view = Craft::$app->getView();
		$templateMode = $view->getTemplateMode();
		$view->setTemplateMode($view::TEMPLATE_MODE_SITE);

		$variables['element'] = $element;
		$variables['this'] = $this;

		$options = json_decode('[' . $view->renderString($this->dropdownOptions, $variables) . ']', true);

		$view->setTemplateMode($templateMode);

		foreach ($options as $key => $option) :

		    if ($this->isFresh($element) ) :
		    	if (!empty($option['default'])) :
		    		$value = $option['value'];
				endif;
			endif;

			// unset($options[$key]['selected']);

		endforeach;

        return Craft::$app->getView()->renderTemplate('hubspot/_includes/forms/hubspotBlogPost', [
            'name' => $this->handle,
            'value' => $value,
            'options' => $options,
        ]);
    }
}
