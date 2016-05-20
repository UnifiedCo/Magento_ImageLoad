/**
 * LogicSpot_ImageLoad
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @category    LogicSpot
 * @package     LogicSpot_ImageLoad
 * @copyright   Copyright (c) 2015 LogicSpot (http://www.logicspot.com)
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License v3.0
 */

function isJqueryEnable() {
    return !(typeof jQuery === "undefined");
}
function isModernizrEnable() {
    return !(typeof Modernizr === "undefined");
}
/**
 * Function that replaces visible image with the retrieved hidden one.
 * @param container
 */
function toggleImage(container) {
    var visibleImg = container.find('img:visible');
    var hiddenImg  = container.find('img:hidden');
    if (hiddenImg.length != 0) {
        visibleImg.hide();
        hiddenImg.show();
    }
}
if (isJqueryEnable() && (!isModernizrEnable() || (isModernizrEnable() && !Modernizr.touch))) {
    jQuery(document).ready(function($) {
        $(document).on({
            mouseenter: function () {
                if (!IMAGELOAD_ENABLE) {
                    return false;
                }
                var container = $(this).find('a.product-image');
                container.addClass('hover');
                //if there is no image loaded, load using ajax
                if (!container.hasClass('img-loaded')) {
                    var url = container.attr('href');
                    // Create new offscreen image to get it's actual width and height (needed for responsive layouts)
                    var testImage = new Image();
                    testImage.src = container.find('img').attr("src");
                    var width = testImage.width;
                    var height = testImage.height;

                    container.addClass('img-loaded');

                    $.ajax({
                        type: "GET",
                        url: BASE_URL + "imageload/index/index",
                        data: {url: url, width: width, height: height},
                        beforeSend: function() {
                            container.trigger('imageload:start');
                        },
                        complete: function() {
                            container.trigger('imageload:stop');
                        },
                        success: function (dataString) {
                            var getData = $.parseJSON(dataString);
                            //if ajax finished with success, write new image url into data for container
                            if (getData.error == false) {
                                // let browser load new image before showing it on frontend
                                var image = new Image();
                                image.src = getData.img;
                                image.onload = function() {
                                    container.append(container.find('img').clone().attr('src', getData.img).hide());

                                    //do not show new image if customer changed the hover before ajax call was completed
                                    if (container.hasClass('hover')) {
                                        toggleImage(container);
                                    }
                                }
                            }
                        }
                    });
                } else {
                    toggleImage(container);
                }
            },
            mouseleave: function () {
                //show old image
                var container = $(this).find('a.product-image');
                container.removeClass('hover');
                if (container.hasClass('img-loaded')) {
                    toggleImage(container);
                }
            }
        }, ".category-products .item");
    })
}