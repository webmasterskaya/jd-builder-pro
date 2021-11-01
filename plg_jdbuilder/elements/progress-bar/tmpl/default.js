(function () {

    var JDBuilderElementProgressBar = function (element) {
        element.addClass('jdb-progressbars');

        var html = [];
        var bars = element.params.get('bars', []);
        if (!bars.length) {
            return '';
        }

        // params
        var barType = element.params.get('barType', 'default');
        var barHeight = element.params.get('barHeight', {
            value: 30
        });
        var labelPosition = element.params.get('labelPosition', 'inside');
        var displayLabels = element.params.get('displayLabels', true);
        var displayPercentageLabels = element.params.get('displayPercentageLabels', true);
        var barStriped = element.params.get('barStriped', false);
        var barStripedAnimation = element.params.get('barStripedAnimation', false);

        html.push('<div>');
        let _index = 0;
        bars.forEach(function (_bar) {
            _index++;
            html.push('<div class="jdb-progressbar-' + _index + '" jdb-progressbar="type:' + barType + ';height:' + barHeight.value + ';displayLabels:' + displayLabels + ';displayPercentageLabels:' + displayPercentageLabels + ';striped:' + barStriped + ';animation:' + barStripedAnimation + ';label:' + _bar.title + ';position: ' + labelPosition + ';value:' + _bar.value.value + '"><div class="jdb-progressbar-progress"></div></div>');
        });
        html.push('</div>');
        elementStyling(element);
        return html.join('');
    };

    function elementStyling(element) {


        var barStyle = new JDBRenderer.ElementStyle(".jdb-progressbar");
        var progress = new JDBRenderer.ElementStyle(".jdb-progressbar-progress");
        var labels = new JDBRenderer.ElementStyle(".jdb-progressbar-labels > span");
        element.addChildrenStyle([progress, labels, barStyle]);

        /* Progress Styling */
        barStyle.addCss('background-color', element.params.get('barColor', ''));

        let barSpacing = element.params.get('barSpacing', null);
        if (barSpacing != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in barSpacing) && JDBRenderer.Helper.checkSliderValue(barSpacing[_deviceObj.key])) {
                    barStyle.addCss("margin-bottom", barSpacing[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        progress.addCss('background-color', element.params.get('barProgressColor', ''));
        labels.addCss('color', element.params.get('labelColor', ''));

        var typography = element.params.get('labelTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    labels.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        // Button Border
        let barBorderStyle = element.params.get('barBorderStyle', 'solid');
        barStyle.addCss("border-style", barBorderStyle);

        if (barBorderStyle != 'none') {
            let borderWidth = element.params.get('barBorderWidth', null);
            if (borderWidth !== null) {
                JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                    if (_deviceObj.key in borderWidth) {
                        barStyle.addStyle(JDBRenderer.Helper.spacingValue(borderWidth[_deviceObj.key], "border"), _deviceObj.type);
                    }
                });
            }
            barStyle.addCss('border-color', element.params.get('barBorderColor', ''));
        }

        // Button Radius
        var borderRadius = element.params.get('barBorderRadius', null);
        if (borderRadius !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in borderRadius) {
                    barStyle.addStyle(JDBRenderer.Helper.spacingValue(borderRadius[_deviceObj.key], "radius"), _deviceObj.type);
                    progress.addStyle(JDBRenderer.Helper.spacingValue(borderRadius[_deviceObj.key], "radius"), _deviceObj.type);
                }
            });
        }

        barStyle.addCss('box-shadow', element.params.get('barBoxShadow', ''));
    }

    window.JDBuilderElementProgressBar = JDBuilderElementProgressBar;

})();