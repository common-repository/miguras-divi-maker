=== DIVI Maker - Create your own DIVI Modules ===
Contributors: miguras
Donate link: http://miguras.com/
Tags: divi, divi theme, divi plugin, divi modules, divi builder
Requires at least: 4.9
Tested up to: 4.9.8
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A DIVI Plugin to easyly create your own DIVI modules.

== Description ==

### DIVI Maker Plugin

After you succesfully installed, you will see a new menu at your admin dashboard named "Divi Maker", go there and add a new item. Once you are there, you will see different fields.

Title: This field will be used to identify your module. For example, if title says "My DIVI Module"...The module title will be the same, so when you launch the DIVI modules modal, you will see your module with this name. and the module ID it will be "my_divi_module". This is the only required field.

Below this, you will see the default wordpress editor. There, you must insert the output content. you can use PHP Directly using default opening and closing PHP tags.(be careful!). If you don't know how to use php, it is possible activate the visual option at page bottom.

At right, you will see a metabox to add options to your new DIVI module.

* Field ID: Must be unique and it's only for internal purpose (identify from rest).
* Field Type.
* Field Label: Title above the field.
* Field Description: Explanation to users of how to use the field.
* Toggle: Where it will appear the field inside the DIVI options modal.

to retrieve the value added by users, you must insert inside the output content with this format: dm=%fieldidoftheoption%=dm

### CSS & JAVASCRIPT FIELDS

Here you can add the javascript and css. Both fields will create related files, so if you want, you could minify the content at any online editor around the web and then paste the content here.

### DEPENDENCIES
here, you can add urls to add external css or javascript files.


== Installation ==

Automatic installation is the easiest option as WordPress handles the file transfers itself and you do not need to leave your web browser. To do an automatic install of the plugin, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

### How to use

After you succesfully installed, you will see a new menu at your admin dashboard named "Divi Maker", go there and add a new item. Follow the hints at top right.


== Frequently Asked Questions ==

== Changelog ==
