## MP-Forms
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Description
A wordpress plugin to create custom form. Made for developers.

## Installation Manually
1. Download the latest archive and extract to a folder
2. Upload the plugin to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Ensure you update the recaptcha code in `mpforms.php`

## Development

If you plan to make changes to the form or add new forms, ensure your device has the plugin dependencies installed.

1. `yarn install` to install node modules
2. `npx webpack` to watch for changes


## i18n Tools

The Plugin uses a variable to store the text domain used when internationalizing strings throughout the code. To take advantage of this method, there are tools that are recommended for providing correct, translatable files:

* [Poedit](http://www.poedit.net/)
* [makepot](http://i18n.svn.wordpress.org/tools/trunk/)
* [i18n](https://github.com/grappler/i18n)

Any of the above tools should provide you with the proper tooling to internationalize the plugin.

However, if you still face problems translating the strings with an automated tool/process, replace `$this->plugin_text_domain` with the literal string of your plugin's text domain.

## Adding new forms

The code for each form is kept in a few places:

```
inc/admin/forms # backend code to display form data from DB
inc/frontend/forms # frontend code to display the form
```

#### Steps to clone
1. Start by copying the form folders in the locations mentioned above and pasting them with its new name
2. Update namespaces and class names.
3. Update db.php with the fields for your new form. Note that this db.php file is read when the plugin is activated. If you add a new form toggle the plugina activation.
4. Update the webpack.config.js to have the new form for building js.
5. Ensure you have updated the render_mail_html in the frontend class with the fields you added in the db.php.
6. Get coding! Update the form.php file with the form. Follow the current form as an example.





