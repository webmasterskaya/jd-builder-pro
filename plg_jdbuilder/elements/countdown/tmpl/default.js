(function () {

    var JDBuilderElementCountdown = function (element) {

        element.addClass('jdb-countdown');
        var date = element.params.get('date', dateMDYYYY(''));
        var time = element.params.get('time', {
            hours: 0,
            minutes: 0
        });

        time.hours = ('hours' in time) ? time.hours : 0;
        time.minutes = ('minutes' in time) ? time.minutes : 0;

        time.hours = parseInt(time.hours, 10) < 10 ? '0' + parseInt(time.hours, 10) : time.hours;
        time.minutes = parseInt(time.minutes, 10) < 10 ? '0' + parseInt(time.minutes, 10) : time.minutes;

        date = (dateMDYYYY(date) + 'T' + time.hours + ':' + time.minutes + ':00' + _JDBTIMEZONE);

        var onAfterExpire = element.params.get('onAfterExpire', 'hide');
        var redirect = element.params.get('redirect', '');
        var wait = element.params.get('redirectWait', 3000);

        element.addAttribute('jdb-countdown', 'date: ' + date + ';after:' + onAfterExpire + ';redirect:' + encodeURI(redirect) + ';wait:' + wait + ';preview:true');



        var html = [];

        var viewDays = element.params.get('viewDays', true);
        var viewHours = element.params.get('viewHours', true);
        var viewMinutes = element.params.get('viewMinutes', true);
        var viewSeconds = element.params.get('viewSeconds', true);

        var labelType = element.params.get('labelType', 'auto');
        var viewType = element.params.get('viewType', 'block');
        var labels = {
            'days': 'Days',
            'hours': 'Hours',
            'minutes': 'Minutes',
            'seconds': 'Seconds'
        };
        if (labelType === 'custom') {
            ['days', 'hours', 'minutes', 'seconds'].forEach(function (_key) {
                var labelText = element.params.get(_key + 'Label', '');
                labels[_key] = labelText;
            });
        }

        html.push('<div class="jdb-countdown-container">');
        html.push('<div class="jdb-countdown-inner jdb-countdown-' + viewType + '">');
        html.push('<div class="jdb-row jdb-no-gutters">');
        if (viewDays) {
            html.push('<div class="jdb-col jdb-countdown-item">');
            html.push('<span class="jdb-countdown-number jdb-countdown-days"></span>');
            if (labelType !== 'none' && labels['days'] != '') {
                html.push('<span class="jdb-countdown-label" data-label="' + labels['days'] + '">' + labels['days'] + '</span>');
            }
            html.push('</div>');
        }
        if (viewHours) {
            html.push('<div class="jdb-col jdb-countdown-item">');
            html.push('<span class="jdb-countdown-number jdb-countdown-hours"></span>');
            if (labelType !== 'none' && labels['hours'] != '') {
                html.push('<span class="jdb-countdown-label" data-label="' + labels['hours'] + '">' + labels['hours'] + '</span>');
            }
            html.push('</div>');
        }
        if (viewMinutes) {
            html.push('<div class="jdb-col jdb-countdown-item">');
            html.push('<span class="jdb-countdown-number jdb-countdown-minutes"></span>');
            if (labelType !== 'none' && labels['minutes'] != '') {
                html.push('<span class="jdb-countdown-label" data-label="' + labels['minutes'] + '">' + labels['minutes'] + '</span>');
            }
            html.push('</div>');
        }
        if (viewSeconds) {
            html.push('<div class="jdb-col jdb-countdown-item">');
            html.push('<span class="jdb-countdown-number jdb-countdown-seconds"></span>');
            if (labelType !== 'none' && labels['seconds'] != '') {
                html.push('<span class="jdb-countdown-label" data-label="' + labels['seconds'] + '">' + labels['seconds'] + '</span>');
            }
            html.push('</div>');
        }
        html.push('</div>');
        html.push('</div>');

        if (onAfterExpire == 'message' || onAfterExpire == 'hide+message') {
            html.push('<div class="jdb-countdown-message">' + element.params.get('message', '') + '</div>');
        }
        html.push('</div>');

        elementStyling(element);
        return html.join('');
    }

    function elementStyling(element) {

        var containerStyle = new JDBRenderer.ElementStyle(".jdb-countdown-container");
        var boxStyle = new JDBRenderer.ElementStyle(".jdb-countdown-item");
        var numberStyle = new JDBRenderer.ElementStyle(".jdb-countdown-number");
        var labelStyle = new JDBRenderer.ElementStyle(".jdb-countdown-label");
        var messageStyle = new JDBRenderer.ElementStyle(".jdb-countdown-message");

        element.addChildrenStyle([containerStyle, boxStyle, numberStyle, labelStyle, messageStyle]);

        var width = element.params.get('countdownWidth', null);
        if (width != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in width) && JDBRenderer.Helper.checkSliderValue(width[_deviceObj.key])) {
                    if (width[_deviceObj.key].value != '' && width[_deviceObj.key].value != null) {
                        containerStyle.addCss('width', width[_deviceObj.key].value + width[_deviceObj.key].unit, _deviceObj.type);
                    }
                }
            });
        }

        boxStyle.addCss('background-color', element.params.get('countdownBackground', ''));
        JDBRenderer.Helper.applyBorderValue(boxStyle, element.params, "countdownBorder");

        var countdownSpace = element.params.get('countdownSpace', null);
        if (countdownSpace !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (JDBRenderer.Helper.checkSliderValue(countdownSpace[_deviceObj.key])) {
                    boxStyle.addCss('margin', '0 ' + countdownSpace[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        var padding = element.params.get('countdownPadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    boxStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }

        numberStyle.addCss('color', element.params.get('numberColor', ''));

        var typography = element.params.get('numberTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    numberStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        labelStyle.addCss('color', element.params.get('labelColor', ''));

        var typography = element.params.get('labelTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    labelStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }


        messageStyle.addCss('color', element.params.get('messageColor', ''));

        var typography = element.params.get('messageTypography', null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    messageStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        var padding = element.params.get('messagePadding', null);
        if (padding != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in padding) {
                    messageStyle.addStyle(JDBRenderer.Helper.spacingValue(padding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }
    }

    function dateMDYYYY(date) {
        var date = new Date(date);
        if (isNaN(date.getTime())) {
            date = new Date();
        }
        var dd = date.getDate() < 10 ? ('0' + date.getDate()) : ('' + date.getDate());
        var mm = date.getMonth() < 9 ? ('0' + (date.getMonth() + 1)) : ('' + (date.getMonth() + 1));
        var yyyy = date.getFullYear() + '';
        return yyyy + '-' + mm + '-' + dd;
    }


    window.JDBuilderElementCountdown = JDBuilderElementCountdown;

})();