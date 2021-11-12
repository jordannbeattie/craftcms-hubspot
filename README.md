# Hubspot Integration
Enable the power of Hubspot CRM within CraftCMS.

## Features
### Forms
Build and manage your forms in Hubspot and use the Hubspot Form field to get the ID.

## Requirements
This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation
```
composer require jordanbeattie/craftcms-hubspot
```

From the control panel, install and enable the plugin.

Set your [Hubspot API Key](https://knowledge.hubspot.com/integrations/how-do-i-get-my-hubspot-api-key) in the settings page.

## Usage
You can use the Hubspot Form field type to allow users to select a form from Hubspot. Then, in your template, simply use the render function to render your form. 
```
{{ craft.hubspot.render(myHubspotFormField) }}
```

## Maintenance
This package is maintained on an as-needed basis. Feature requests and bug reports are welcomed.

## Contact
Jordan Beattie. <br>
jordan@jordanbeattie.com <br>
www.jordanbeattie.com
