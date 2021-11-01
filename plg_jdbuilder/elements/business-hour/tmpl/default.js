(function () {

    var JDBuilderElementBusinessHour = function (element) {
        element.addClass('jdb-business-hours');

        var html = [];

        var days = element.params.get('days', []);

        days.forEach(function (day, index) {
            html.push('<div class="jdb-bh-row">');
            html.push('<div class="jdb-bh-day">');
            html.push(day.day);
            html.push('</div>');
            html.push('<div class="jdb-bh-time">');
            html.push(day.time);
            html.push('</div>');
            html.push('</div>');
            if (day.style) {
                var rowStyle = new JDBRenderer.ElementStyle(".jdb-bh-row:nth-child(" + (index + 1) + ")");
                var rowDayStyle = new JDBRenderer.ElementStyle(".jdb-bh-row:nth-child(" + (index + 1) + ") .jdb-bh-day");
                var rowTimeStyle = new JDBRenderer.ElementStyle(".jdb-bh-row:nth-child(" + (index + 1) + ") .jdb-bh-time");
                rowStyle.addCss('background', day.background);
                rowDayStyle.addCss('color', day.dayColor);
                rowTimeStyle.addCss('color', day.timeColor);
                element.addChildrenStyle([rowStyle, rowDayStyle, rowTimeStyle]);
            }
        });



        rowStyle = new JDBRenderer.ElementStyle(".jdb-bh-row:not(:last-child)");
        var dayStyle = new JDBRenderer.ElementStyle(".jdb-bh-row .jdb-bh-day");
        var timeStyle = new JDBRenderer.ElementStyle(".jdb-bh-row .jdb-bh-time");
        element.addChildrenStyle([rowStyle, dayStyle, timeStyle]);

        var padding = element.params.get('rowPadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    rowStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        var divider = element.params.get('divider', false);
        if (divider) {
            rowStyle.addCss('border-bottom-style', element.params.get('dividerStyle', 'solid'));
            rowStyle.addCss('border-bottom-color', element.params.get('dividerColor', ''));
            var dividerWeight = element.params.get('dividerWeight', null);
            if (dividerWeight != null) {
                if (JDBRenderer.Helper.checkSliderValue(dividerWeight)) {
                    rowStyle.addCss('border-bottom-width', dividerWeight.value + 'px');
                }
            }
        }

        dayStyle.addCss('color', element.params.get('dayColor', ''));

        var typography = element.params.get('dayTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    dayStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        timeStyle.addCss('color', element.params.get('timeColor', ''));

        var typography = element.params.get('timeTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    timeStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        if (element.params.get("striped", true)) {
            var oddStyle = new JDBRenderer.ElementStyle(".jdb-bh-row:nth-child(odd)");
            var evenStyle = new JDBRenderer.ElementStyle(".jdb-bh-row:nth-child(even)");
            element.addChildrenStyle([oddStyle, evenStyle]);

            oddStyle.addCss('background-color', element.params.get('oddBackground', ''));
            evenStyle.addCss('background-color', element.params.get('evenBackground', ''));
        }

        return html.join('');
    };

    window.JDBuilderElementBusinessHour = JDBuilderElementBusinessHour;

})();