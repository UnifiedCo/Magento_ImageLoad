#Imageload by [LogicSpot]

This module allows to show different images after hovering over image in category view.
By default module will show SECOND image from image gallery, but it's a possibility of changing hover image in gallery tab.

##Features
- Lazy loading of hover images - images will load only once, and only after product hover
- You can set custom image as hover one, or leave functionality as default and show the Second image in gallery

##Requirements
This module requires jQuery to run.
 
##Installation
There are 3 ways of installing ImageLoad module:

- use [modman] script - run modman clone https://github.com/logicspot/imageload
- use [magento-composer-installer] composer wrapper for Magento modules

    Add the "logicspot/imageload" to your project requirements, and run composer update
    
- Download module files and unpack them into your Magento install root directory

Module does not require passing any additional parameters in DOM tree, it will retrieve product image using product url

If you're using custom package for templates you also need to copy all files from app/design/frontend/base/default/layout/logicspot and 
app/design/frontend/base/default/template/logicspot into your package templates folder.
 
After installing module, logout and login into admin and clear Magento cache.

##License
This module is distributed under GNU General Public License v3.0. Full text of the License can be found in LICENSE.txt file


[LogicSpot]:http://www.logicspot.com/
[Magento]:http://magento.com/
[modman]:https://github.com/colinmollenhour/modman
[magento-composer-installer]:https://github.com/Cotya/magento-composer-installer