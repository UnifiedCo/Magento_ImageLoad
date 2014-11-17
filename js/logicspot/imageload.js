function isJqueryEnable() {
    return !(typeof jQuery === "undefined");
}
function isModernizrEnable() {
    return !(typeof Modernizr === "undefined");
}
/**
 * Function that replaces current src with the one stored in data storage, and saves old for ruther processing
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
                var container = $(this).find('a.product-image');
                container.addClass('hover');
                //if there is no image loaded, load using ajax
                if (!container.hasClass('img-loaded')) {
                    var url = container.attr('href');
                    // Create new offscreen image to get it's actual width and height
                    var testImage = new Image();
                    testImage.src = container.find('img').attr("src");
                    var width = testImage.width;
                    var height = testImage.height;

                    container.addClass('img-loaded');

                    $.ajax({
                        type: "GET",
                        url: BASE_URL + "imageload/index/index",
                        data: {url: url, width: width, height: height},
                        success: function (dataString) {
                            var getData = $.parseJSON(dataString);
                            //if ajax finished with success, write new image url into data for container
                            if (getData.error == false) {
                                container.append(container.find('img').clone().attr('src', getData.img).hide());
                            }

                            //do not show new image if customer changed the hover before ajax call was completed
                            if (container.hasClass('hover')) {
                                toggleImage(container);
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