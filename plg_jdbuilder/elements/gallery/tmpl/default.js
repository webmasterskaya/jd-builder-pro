(function () {

    var JDBuilderElementGallery = function (element) {

        var uKey = elementStyling(element);

        element.addClass('jdb-gallery-element');
        var layout = element.params.get('layout', 'masonry');
        var items = element.params.get('items', []);
        uKey.push(layout);

        var settings = JDBRenderer.Helper.globalSettings();
        var lightbox = element.params.get('lightbox', '');
        lightbox = lightbox == '' ? (settings.get('lightbox', true) == 'true' ? true : false) : (Number(lightbox) ? true : false);

        var galleryClass = [];
        var galleryItemClass = ['jdb-gallery-item'];
        galleryItemClass.push('jdb-caption-' + element.params.get('caption', 'never'));
        if (layout === 'masonry' || layout === 'grid') {
            galleryClass.push('jdb-row');
            galleryClass.push('jdb-no-gutters');
            var columnCount = element.params.get('columnCount', null);
            if (columnCount != null) {

                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in columnCount) {
                        const key = (_deviceObj.key == 'xs' ? '' : (_deviceObj.key == 'sm' ? 'md-' : 'lg-'))
                        galleryItemClass.push('jdb-col-' + key + (12 / columnCount[_deviceObj.key]));
                        uKey.push(columnCount[_deviceObj.key]);
                    }
                });
            } else {
                galleryItemClass.push('jdb-col-4');
            }
        }

        var html = [];
        var filters = new Map();
        var hasFilters = false;
        html.push('<div class="jdb-gallery-container">');
        var itemsHtml = [];

        items.forEach(function (item) {
            if (item.image != '') {
                let itemClass = Object.assign([], galleryItemClass);
                if (typeof item.tag !== 'undefined' && item.tag != '') {
                    var tags = item.tag.split(',');
                    tags.forEach(function (tag) {
                        hasFilters = true;
                        filters.set(tag.toLowerCase(), tag);
                        itemClass.push('jdb-gallery-item-' + tag.toLowerCase());
                    });
                }
                itemsHtml.push('<div class="' + itemClass.join(' ') + '">');
                if (lightbox) {
                    itemsHtml.push('<a href="' + JDBRenderer.Helper.mediaValue(item.image) + '" data-jdb-lightbox="lightbox-' + element.id + '" data-jdb-lightbox-caption="' + JDBRenderer.Helper.getLightboxContent('description', item.title, item.caption, item.alt) + '" data-jdb-lightbox-title="' + JDBRenderer.Helper.getLightboxContent('title', item.title, item.caption, item.alt) + '">');
                }
                if (layout !== 'grid') {
                    itemsHtml.push('<img src="' + JDBRenderer.Helper.mediaValue(item.image) + '" />');
                } else {
                    itemsHtml.push('<div class="jdb-gallery-item-inner" style="background-image: url(\'' + (JDBRenderer.Helper.mediaValue(item.image)) + '\')"></div>');
                }
                if (lightbox) {
                    itemsHtml.push('</a>');
                }
                if (element.params.get('caption', 'never') != 'never' && item.caption != '' && item.caption != undefined) {
                    itemsHtml.push('<' + element.params.get('captionTag', 'span') + ' class="jdb-gallery-item-caption">' + item.caption + '</' + element.params.get('captionTag', 'span') + '>');
                }
                itemsHtml.push('</div>');
                uKey.push(item.image);
            }
        });

        var rowHeight = element.params.get('rowHeight', {
            "value": 200,
            "unit": "px"
        });

        var gridGap = element.params.get('gridGap', {
            "value": 10,
            "unit": "px"
        });

        var labelAll = element.params.get('labelAll', 'All');
        var selectedFilter = element.params.get('selectedFilter', '');
        selectedFilter = selectedFilter.toLowerCase() == labelAll.toLowerCase() ? '*' : selectedFilter;

        uKey.push(filters.size);
        uKey.push(element.params.get('filters', false) ? '1' : '0');

        html.push('<div class="' + galleryClass.join(' ') + '" jdb-' + layout + '-gallery="ukey:' + JDBRenderer.Helper.hashCode(uKey.join('')) + ';rowHeight:' + rowHeight.value + ';gridGap:' + gridGap.value + ';selected:' + selectedFilter + '">');
        html.push(itemsHtml.join(''));
        html.push('</div>');
        if ((element.params.get('filters', false)) && layout == 'masonry' && hasFilters) {
            html.push('<div class="jdb-gallery-filters jdb-d-flex jdb-justify-content-' + (element.params.get('filterAlignment', 'left')) + '">');
            if (element.params.get('showAll', false)) {
                html.push('<button type="button" data-filter="*">' + labelAll + '</button>');
            }
            filters.forEach(function (filter, key) {
                html.push('<button type="button" data-filter=".jdb-gallery-item-' + key + '">' + filter + '</button>');
            });
            html.push('</div>');
        }
        html.push('</div>');
        return html.join('');
    }

    function elementStyling(element) {
        var uKey = [];
        var galleryStyle = new JDBRenderer.ElementStyle(".jdb-gallery");
        var itemStyle = new JDBRenderer.ElementStyle(".jdb-gallery-item");
        var captionStyle = new JDBRenderer.ElementStyle(".jdb-gallery-item-caption");
        var filterStyle = new JDBRenderer.ElementStyle(".jdb-gallery-filters > button");
        var filterHoverStyle = new JDBRenderer.ElementStyle(".jdb-gallery-filters > button:hover, .jdb-gallery-filters > button.active:hover");
        var filterActiveStyle = new JDBRenderer.ElementStyle(".jdb-gallery-filters > button.active");

        element.addChildrenStyle([galleryStyle, itemStyle, captionStyle, filterStyle, filterHoverStyle, filterActiveStyle]);
        var layout = element.params.get('layout', 'masonry');

        if (layout == 'masonry' || layout == 'grid') {
            var gridMargin = element.params.get('gridMargin', null);
            if (gridMargin != null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if ((_deviceObj.key in gridMargin) && JDBRenderer.Helper.checkSliderValue(gridMargin[_deviceObj.key])) {
                        uKey.push(gridMargin[_deviceObj.key].value);
                        galleryStyle.addCss('margin-left', '-' + (gridMargin[_deviceObj.key].value / 2) + 'px', _deviceObj.type);
                        galleryStyle.addCss('margin-right', '-' + (gridMargin[_deviceObj.key].value / 2) + 'px', _deviceObj.type);
                        itemStyle.addCss('margin-bottom', gridMargin[_deviceObj.key].value + 'px', _deviceObj.type);
                        itemStyle.addCss('padding-right', (gridMargin[_deviceObj.key].value / 2) + 'px', _deviceObj.type);
                        itemStyle.addCss('padding-left', (gridMargin[_deviceObj.key].value / 2) + 'px', _deviceObj.type);
                        captionStyle.addCss('width', 'calc(100% - ' + (gridMargin[_deviceObj.key].value + 'px') + ')', _deviceObj.type);
                        captionStyle.addCss('left', (gridMargin[_deviceObj.key].value / 2) + 'px', _deviceObj.type);
                    }
                });
            }
        }

        if (layout === 'grid') {
            var rowHeight = element.params.get('rowHeight', {
                "value": 200,
                "unit": "px"
            });
            itemStyle.addCss('height', rowHeight.value + 'px');
        }

        if (element.params.get('caption', 'never') != 'never') {
            captionStyle.addCss('color', element.params.get('captionColor', ''));
            captionStyle.addCss('background-color', element.params.get('captionBackground', ''));

            var typography = element.params.get('captionTypography', null);
            if (typography !== null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in typography) {
                        captionStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                    }
                });
            }
            var padding = element.params.get('captionPadding', null);
            if (padding != null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in padding) {
                        captionStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                    }
                });
            }
        }

        filterStyle.addCss('color', element.params.get('filterColor', ''));
        filterStyle.addCss('background-color', element.params.get('filterBackground', ''));
        JDBRenderer.Helper.applyBorderValue(filterStyle, element.params, "filterBorder");
        var typography = element.params.get("filterTypography", null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    filterStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }
        var padding = element.params.get('filterPadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    filterStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        filterHoverStyle.addCss('color', element.params.get('filterHoverColor', ''));
        filterHoverStyle.addCss('background-color', element.params.get('filterHoverBackground', ''));
        JDBRenderer.Helper.applyBorderValue(filterHoverStyle, element.params, "filterHoverBorder");

        filterActiveStyle.addCss('color', element.params.get('filterActiveColor', ''));
        filterActiveStyle.addCss('background-color', element.params.get('filterActiveBackground', ''));
        JDBRenderer.Helper.applyBorderValue(filterActiveStyle, element.params, "filterActiveBorder");

        return uKey;
    }

    window.JDBuilderElementGallery = JDBuilderElementGallery;

})();