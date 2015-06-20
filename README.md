BIG CMS for Yii 2
===================================

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

**STILL UNDER DEVELOPMENT**

BIG CMS is a ready to use Yii 2 web application split into frontend and backend. It is prepared for shared hosts but built with a flexibility that makes it suitable as a starting-kit.

BIG CMS is based on Yii 2 modules and a concept of *Blocks*. You can create your own blocks (quite easily) and integrate them into BIG CMS. By default BIG CMS comes with 4 blocks.

BIG CMS is built with [Big Framework](https://github.com/bigbrush/yii2-big).


Installing via Composer <span id="installing-via-composer"></span>
-----------------------------------
If you do not already have Composer installed, you may do so by following the instructions at [Yii Docs](https://github.com/yiisoft/yii2/blob/master/docs/guide/start-installation.md#installing-via-composer-).

With Composer installed, you can install Big Cms by running the following commands under a Web-accessible folder:
~~~
composer create-project --prefer-dist --stability=dev bigbrush/yii2-bigcms bigcms
cd bigcms
yii cms/install
~~~

Then follow the on screen instruction which helps to specify your database login credentials.

After the installion has finished go to http://YOURSITE.COM/admin/ and login with:
  - Username: bigadmin
  - Password: bigadmin

**REMEMBER TO CHANGE PASSWORD WHEN USING IN PRODUCTION**


Features <span id="bigcms-features"></span>
-----------------------------------
  - SEO optimized content and menu system
  - Dynamic Yii 2 themes (include blocks in your theme or layout file)
  - Ready for shared hosts
  - Frontend and backend access
  - Menu system with nested menu items based on [Yii2 Nested Sets](https://github.com/creocoder/yii2-nested-sets)
  - WYSIWYG editor based on [TinyMCE 4](http://www.tinymce.com)
  - File manager based on [elFinder](http://elfinder.org)
  - Extension manager to install custom blocks
  - Template system that enables you to structure pages individually
  - Flexible and ready as a development platform
  - User registration
  - Development features provided by [Big Framework](https://github.com/bigbrush/yii2-big)
  - Ready to use admin theme
  - Menu component used in the backend
  - Toolbar component used in the backend
  - 4 widgets
    - Alert (copied from Yii 2 advanced template)
    - DeleteButton (used in the backend as a UI element for deleting content)
    - Popover (base class the DeleteButton)
    - RadioButtonGroup (yes/no buttons based on bootstrap)
  - Fully integrated with bootstrap 3
  - Doesn't impose any rules


Modules <span id="bigcms-modules"></span>
-----------------------------------
**Pages**
The "Pages" module provides SEO optimized page content integrated with the menu system. Links and media can be inserted into a page and meta tags can be set in the backend. It provides the following features:

  - SEO optimized pages
  - Edit pages with a TinyMCE editor
  - Add BIG CMS links and media to pages
  - Upload and handle media while editing a page
  - Assign an individual template to each page

**Users**
The "Users" module provides user management for Big Cms.

  - Create and edit users
  - Backend login


Templates <span id="bigcms-templates"></span>
-----------------------------------
Templates are used to style pages individually by assigning blocks to positions. The template will be parsed when Yii handles the request.

  - Assign created blocks to template positions
  - Multiple templates with different blocks
  - Drag 'n drop feature

**Enabling templates in a Yii 2 theme**
To enable templates in your theme place a file called "positions.php" in the root directory. When you edit a template this file is being loaded for available positions in the active theme.

The file should look like the following:

~~~php
return [
    'POSITION-ID' => 'POSITION NAME',
    'gallery' => 'Gallery',
    'mainmenu' => 'Main menu',
    ...
];
~~~

Then in the layout file of your theme you add an include statement like the following:
~~~html
<big:block position="mainmenu" />
~~~

And that's all there is to enabling templates and blocks.


Blocks <span id="bigcms-blocks"></span>
-----------------------------------
A block can be assigned to a template position and will then be rendered when Yii handles the request. After Big Cms has been installed 4 blocks will be available: 

**Menu block**
  - Displays a single menu
  - Select bootstrap styles from a drop down list.
  
**Text block**
  - Displays content created with a TinyMCE editor

**Contact block**
  - Displays a contact form
  - Can be configured to display certain fields.

**Pages categories block**
  - Lists pages from a single category


Built with
-----------------------------------
BIG CMS appreciates the ability to integrate the following libraries:
  - [Font awesome](http://fortawesome.github.io/Font-Awesome/)
  - [HTML5 Sortable](https://github.com/voidberg/html5sortable)
  - [Startbootstrap simple sidebar](https://github.com/IronSummitMedia/startbootstrap-simple-sidebar)
  - [Pixabay TinyMCE skin](https://pixabay.com/en/blog/posts/a-modern-custom-theme-for-tinymce-4-40/)
