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
function showHover(container) {
    var hoverImg = container.find('img.hover-img');
    var otherImg  = container.find('img:not(.hover-img)');
    hoverImg.removeClass('hide');
    otherImg.addClass('hide');
}
function showOther(container) {
    var hoverImg = container.find('img.hover-img');
    var otherImg  = container.find('img:not(.hover-img)').first();
    hoverImg.addClass('hide');
    otherImg.removeClass('hide');
}
if (isJqueryEnable() && (!isModernizrEnable() || (isModernizrEnable() && !Modernizr.touch))) {
    jQuery(document).ready(function($) {
        $(document).on({
            mouseenter: function () {
                if (!IMAGELOAD_ENABLE) {
                    return false;
                }
                var container = $(this);
                container.addClass('hover');
                //if there is no image loaded, load using ajax
                if (!container.hasClass('img-loaded')) {
                    if (IMAGELOAD_METHOD == 1) {
                        initHoverMethod(container);
                    }
                    if (IMAGELOAD_METHOD == 3) {
                        initDataAttributeMethod(container);
                    }
                } else {
                    showHover(container);
                }
            },
            mouseleave: function () {
                //show old image
                var container = $(this);
                container.removeClass('hover');
                if (container.hasClass('img-loaded')) {
                    showOther(container);
                }
            }
        }, ".category-products .item .product-image");
    })
}


function initHoverMethod(container) {
    var url = container.attr('href');
    // Create new offscreen image to get it's actual width and height (needed for responsive layouts)
    var testImage = new Image();
    testImage.src = container.find('img').attr("src");
    var width = testImage.width;
    var height = testImage.height;

    container.addClass('img-loaded');

    jQuery.ajax({
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
            var getData = jQuery.parseJSON(dataString);
            //if ajax finished with success, write new image url into data for container
            if (getData.error == false) {
                // let browser load new image before showing it on frontend
                var image = new Image();
                image.src = getData.img;
                image.onload = function() {
                    container.append(container.find('img').clone().removeAttr('id').attr('src', getData.img).addClass('hover-img hide'));

                    //do not show new image if customer changed the hover before ajax call was completed
                    if (container.hasClass('hover')) {
                        showHover(container);
                    }
                }
            }
        }
    });
}

function initDataAttributeMethod(container) {
    var imageSrc = container.find('img').attr(IMAGELOAD_DATA_ATTRIBUTE);

    if (typeof imageSrc == 'undefined' || imageSrc == '') {
        return false;
    }

    container.addClass('img-loaded');

    // let browser load new image before showing it on frontend
    var image = new Image();
    image.src = imageSrc;
    image.onload = function() {
        container.append(container.find('img').clone().removeAttr('id').attr('src', imageSrc).addClass('hover-img hide'));

        //do not show new image if customer changed the hover before ajax call was completed
        if (container.hasClass('hover')) {
            showHover(container);
        }
    }
}
