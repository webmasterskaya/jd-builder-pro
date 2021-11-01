(function () {

    var JDBuilderElementTestimonial = function (element) {
        element.addClass('jdb-testimonials');
        var testimonials = element.params.get('testimonials', []);
        var skin = element.params.get('skin', '');
        var layout = element.params.get('layout', 'imagestacked');
        var alignment = element.params.get('alignment', 'center');
        var bubblePosition = 'bottom';
        if (skin == 'bubble') {
            switch (layout) {
                case 'imageabove':
                    bubblePosition = 'top';
                    break;
                case 'imageleft':
                    bubblePosition = 'left';
                    break;
                case 'imageright':
                    bubblePosition = 'right';
                    break;
            }
        }

        var imageAlignment = alignment;
        switch (layout) {
            case 'imagestacked':
                if (alignment == 'center') {
                    imageAlignment = 'top';
                } else if (alignment == 'right') {
                    imageAlignment = 'topright';
                } else if (alignment == 'left') {
                    imageAlignment = 'topleft';
                }
                break;
            case 'imageleft':
                imageAlignment = 'top';
                break;
            case 'imageright':
                imageAlignment = 'top';
                break;
        }

        var updatedKey = [];
        var slidesPerView = element.params.get('slidesPerView', null);
        if (slidesPerView != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in slidesPerView) && JDBRenderer.Helper.checkSliderValue(slidesPerView[_deviceObj.key])) {
                    updatedKey.push(slidesPerView[_deviceObj.key].value);
                }
            });
        }

        var scrollInSet = element.params.get('scrollInSet', false);
        var autoplay = element.params.get('autoplay', true);
        var infinite = element.params.get('infinite', true);
        var draggable = element.params.get('draggable', true);
        var pauseOnHover = element.params.get('pauseOnHover', true);
        var autoplayInterval = element.params.get('autoplayInterval', {
            value: 7000,
            unit: 'ms'
        });
        var html = [];

        html.push('<div class="jdb-show-controls" tabindex="-1" jdb-slider="ukey:' + updatedKey.join('') + ';sets:' + scrollInSet + ';autoplay:' + autoplay + ';finite:' + (!infinite) + ';draggable:' + draggable + ';pause-on-hover:' + pauseOnHover + ';autoplay-interval:' + autoplayInterval.value + '">');
        html.push('<ul class="jdb-slider-items">');

        testimonials.forEach(function (testimonial) {
            html.push('<li>');
            html.push('<div class="jdb-testimonial jdb-testimonial-' + layout + '">');
            if (skin != 'bubble' && layout == 'imageabove') {
                html.push('<div class="jdb-testimonial-author-info">');
                if (!JDBRenderer.Helper.empty(testimonial.name)) {
                    html.push('<p class="jdb-testimonial-author-name">' + testimonial.name + '</p>');
                }
                if (!JDBRenderer.Helper.empty(testimonial.designation)) {
                    html.push('<p class="jdb-testimonial-author-designation">');
                    if (!JDBRenderer.Helper.empty(testimonial.url)) {
                        html.push('<a href="' + testimonial.url + '" target="_blank">');
                    }
                    html.push(testimonial.designation);
                    if (!JDBRenderer.Helper.empty(testimonial.url)) {
                        html.push('</a>');
                    }
                    html.push('</p>');
                }
                html.push('</div>');
            }
            if (JDBRenderer.Helper.empty(testimonial.content)) {
                testimonial.content = '';
            }
            html.push('<div class="jdb-testimonial-content' + (skin == 'bubble' ? ' jdb-speach-bubble' : '') + '" ' + (skin == 'bubble' ? 'data-bubble-alignment="' + alignment + '" data-bubble-position="' + bubblePosition + '"' : '') + '><div class="jdb-testimonial-content-inner">' + testimonial.content + '</div></div>');
            html.push('<div class="jdb-testimonial-author jdb-image-card jdb-image-' + imageAlignment + '-card">');
            if (!JDBRenderer.Helper.empty(testimonial.avatar)) {
                html.push('<div class="jdb-testimonial-author-avatar jdb-image-card-img"><img src="' + JDBRenderer.Helper.mediaValue(testimonial.avatar) + '" /></div>');
            }
            if (!(skin != 'bubble' && layout == 'imageabove')) {
                html.push('<div class="jdb-testimonial-author-info jdb-image-card-info">');
                if (!JDBRenderer.Helper.empty(testimonial.name)) {
                    html.push('<p class="jdb-testimonial-author-name">' + testimonial.name + '</p>');
                }
                if (!JDBRenderer.Helper.empty(testimonial.designation)) {
                    html.push('<p class="jdb-testimonial-author-designation">');
                    if (!JDBRenderer.Helper.empty(testimonial.url)) {
                        html.push('<a href="' + testimonial.url + '" target="_blank">');
                    }
                    html.push(testimonial.designation);
                    if (!JDBRenderer.Helper.empty(testimonial.url)) {
                        html.push('</a>');
                    }
                    html.push('</p>');
                }
                html.push('</div>');
            }
            html.push('</div>');
            html.push('</div>');
            html.push('</li>');
        });

        html.push('</ul>');
        var arrows = element.params.get('arrows', true);
        if (arrows) {
            html.push('<div class="jdb-slider-controls jdb-slider-next jdb-slider-inside"><a href="#" jdb-slidenav-next jdb-slider-item="next"><span class="fa fa-chevron-right"></span></a></div><div class="jdb-slider-controls jdb-slider-prev jdb-slider-inside"><a href="#" jdb-slidenav-previous jdb-slider-item="previous"><span class="fa fa-chevron-left"></span></a></div>');
        }


        var pagination = element.params.get('pagination', true);
        if (pagination && !scrollInSet) {
            html.push('<ul class="jdb-slider-nav jdb-dotnav"></ul>');
        }

        html.push('</div>');

        elementStyling(element, bubblePosition);

        return html.join('');
    }

    function elementStyling(element, bubblePosition) {
        var layout = element.params.get('layout', 'imagestacked');
        var skin = element.params.get('skin', '');
        var sliderItemStyle = new JDBRenderer.ElementStyle(".jdb-slider-items > li");
        var testimonialStyle = new JDBRenderer.ElementStyle(".jdb-testimonial");
        var testimonialContentStyle = new JDBRenderer.ElementStyle(".jdb-testimonial-content");
        var testimonialNameStyle = new JDBRenderer.ElementStyle(".jdb-testimonial-author-name");
        var testimonialDesgnationStyle = new JDBRenderer.ElementStyle(".jdb-testimonial-author-designation, .jdb-testimonial-author-designation a");
        var testimonialInfoStyle = new JDBRenderer.ElementStyle(".jdb-testimonial-author-info");
        var avatarStyle = new JDBRenderer.ElementStyle(".jdb-testimonial-author-avatar");
        var avatarImgStyle = new JDBRenderer.ElementStyle(".jdb-testimonial-author-avatar > img");
        var arrowStyle = new JDBRenderer.ElementStyle(".jdb-slider-controls > a");
        var paginationStyle = new JDBRenderer.ElementStyle(".jdb-dotnav>*>*");
        var paginationActiveStyle = new JDBRenderer.ElementStyle(".jdb-dotnav>.jdb-active>*");
        var bubbleStyle = new JDBRenderer.ElementStyle(".jdb-speach-bubble");
        var bubbleAfterStyle = new JDBRenderer.ElementStyle(".jdb-speach-bubble:after");
        element.addChildrenStyle([testimonialContentStyle, testimonialNameStyle, testimonialDesgnationStyle, testimonialInfoStyle, sliderItemStyle, testimonialStyle, avatarStyle, avatarImgStyle, arrowStyle, paginationStyle, paginationActiveStyle, bubbleStyle, bubbleAfterStyle]);

        var alignment = element.params.get('alignment', 'center');

        testimonialContentStyle.addCss('text-align', alignment);
        if (layout == 'imageabove' && skin !== 'bubble') {
            testimonialInfoStyle.addCss('text-align', alignment);
        }


        var slidesPerView = element.params.get('slidesPerView', null);
        if (slidesPerView != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in slidesPerView) && JDBRenderer.Helper.checkSliderValue(slidesPerView[_deviceObj.key])) {
                    sliderItemStyle.addCss('width', (100 / slidesPerView[_deviceObj.key].value) + '%', _deviceObj.type);
                }
            });
        }

        var width = element.params.get('slideWidth', null);
        if (width != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in width) && JDBRenderer.Helper.checkSliderValue(width[_deviceObj.key])) {
                    testimonialStyle.addCss("width", width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                }
            });
        }

        testimonialStyle.addCss('background-color', element.params.get('slideBackground', ''));
        JDBRenderer.Helper.applyBorderValue(testimonialStyle, element.params, "slideBorder");

        var padding = element.params.get('slidePadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    testimonialStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        testimonialStyle.addCss('background-color', element.params.get('slideBackground', ''));

        testimonialContentStyle.addCss('color', element.params.get('slideContentColor', ''));
        testimonialNameStyle.addCss('color', element.params.get('slideNameColor', ''));
        testimonialDesgnationStyle.addCss('color', element.params.get('slideDesignationColor', ''));

        var padding = element.params.get('slideContentPadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    testimonialContentStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        var typography = element.params.get('slideContentTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    testimonialContentStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var typography = element.params.get('slideNameTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    testimonialNameStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var typography = element.params.get('slideDesignationTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    testimonialDesgnationStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var width = element.params.get('avatarSize', null);
        if (width != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in width) && JDBRenderer.Helper.checkSliderValue(width[_deviceObj.key])) {
                    avatarStyle.addCss("max-width", width[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        JDBRenderer.Helper.applyBorderValue(avatarImgStyle, element.params, "avatarBorder");

        var size = element.params.get('arrowSize', null);
        if (size != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in size) && JDBRenderer.Helper.checkSliderValue(size[_deviceObj.key])) {
                    arrowStyle.addCss("font-size", size[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        arrowStyle.addCss('color', element.params.get('arrowColor', ''));

        var size = element.params.get('paginationSize', null);
        if (size != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in size) && JDBRenderer.Helper.checkSliderValue(size[_deviceObj.key])) {
                    paginationStyle.addCss("width", size[_deviceObj.key].value + 'px', _deviceObj.type);
                    paginationStyle.addCss("height", size[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        paginationStyle.addCss('background-color', element.params.get('paginationColor', ''));
        paginationActiveStyle.addCss('background-color', element.params.get('paginationActiveColor', ''));

        bubbleStyle.addCss('background-color', element.params.get('bubbleBackground', ''));
        bubbleStyle.addCss('border-color', element.params.get('bubbleBackground', ''));
        JDBRenderer.Helper.applyBorderValue(bubbleStyle, element.params, "bubbleBorder");

        var padding = element.params.get('bubblePadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    bubbleStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        var borderStyle = element.params.get('bubbleBorderStyle');
        if (borderStyle != '') {
            const borderWidth = element.params.get('bubbleBorderWidth', null);
            if (borderWidth != null && borderStyle != 'none') {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in borderWidth) {
                        if ((bubblePosition in borderWidth[_deviceObj.key]) && !JDBRenderer.Helper.empty(borderWidth[_deviceObj.key][bubblePosition])) {
                            bubbleAfterStyle.addCss('border-width', 'calc(10px + ' + borderWidth[_deviceObj.key][bubblePosition] + '' + borderWidth[_deviceObj.key].unit + ')');
                            if (bubblePosition == 'top') {
                                bubbleAfterStyle.addCss('margin-top', 'calc(-10px - ' + borderWidth[_deviceObj.key][bubblePosition] + '' + borderWidth[_deviceObj.key].unit + ')');
                                bubbleAfterStyle.addCss('margin-bottom', 'auto');
                                bubbleAfterStyle.addCss('margin-left', 'calc(-10px - ' + borderWidth[_deviceObj.key][bubblePosition] + '' + borderWidth[_deviceObj.key].unit + ')');
                            } else if (bubblePosition == 'right') {
                                bubbleAfterStyle.addCss('margin-bottom', 'calc(-10px - ' + borderWidth[_deviceObj.key][bubblePosition] + '' + borderWidth[_deviceObj.key].unit + ')');
                                bubbleAfterStyle.addCss('margin-top', 'auto');
                                bubbleAfterStyle.addCss('margin-right', 'calc(-10px - ' + borderWidth[_deviceObj.key][bubblePosition] + '' + borderWidth[_deviceObj.key].unit + ')');
                            } else {
                                bubbleAfterStyle.addCss('margin-bottom', 'calc(-10px - ' + borderWidth[_deviceObj.key][bubblePosition] + '' + borderWidth[_deviceObj.key].unit + ')');
                                bubbleAfterStyle.addCss('margin-top', 'auto');
                                bubbleAfterStyle.addCss('margin-left', 'calc(-10px - ' + borderWidth[_deviceObj.key][bubblePosition] + '' + borderWidth[_deviceObj.key].unit + ')');
                            }
                        }
                    }
                });
            }
        }
    }

    window.JDBuilderElementTestimonial = JDBuilderElementTestimonial;

})();