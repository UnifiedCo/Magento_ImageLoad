#ImageLoad by [LogicSpot]

This module allows to show different images after hovering over image in category view.
By default module will show SECOND image from image gallery, but it's a possibility of changing hover image in gallery tab.

##Features
- Lazy loading of hover images - images will load only once, and only after product hover
- You can set custom image as hover one, or leave functionality as default and show the Second image in gallery
- Responsive websites ready - hover image will always have resolution of original loaded image no matter of actual size of screen

##Requirements
This module requires jQuery to run.

##Installation
There are 3 ways of installing ImageLoad module:

- use [modman] script - run modman clone https://github.com/LogicSpot/Magento_ImageLoad
- use [magento-composer-installer] composer wrapper for Magento modules

    Add the "logicspot/magento_imageload" to your project requirements, and run composer update --no-plugins --no-scripts magento-hackathon/magento-composer-installer

- install using Magento Connect with extension key "logicspot-imageload"
- Download module files and unpack them into your Magento install root directory

Module does not require passing any additional parameters in DOM tree, it will retrieve product image using product url

If you're using custom package for templates you also need to copy all files from app/design/frontend/base/default/layout/logicspot and
app/design/frontend/base/default/template/logicspot into your package templates folder.

After installing module, logout and login into admin and clear Magento cache.

##Custom themes
If you're using heavily modified theme which don't have standard magento "product-image" class added to images on product list you need to modify
the imageload.js file to match your DOM structure. Moreover if any of your modules is used to replace current product image with color swatches
make sure the ImageLoad module works correctly.

##Showcase
![Hover images](http://i.imgur.com/lUWCnle.gif)

##License
This module is distributed under GNU General Public License v3.0. Full text of the License can be found in LICENSE.txt file


[LogicSpot]:http://www.logicspot.com/
[Magento]:http://magento.com/
[modman]:https://github.com/colinmollenhour/modman
[magento-composer-installer]:https://github.com/Cotya/magento-composer-installer
