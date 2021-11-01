"use strict";
/**
 * FieldHelper class.
 */
function FieldHelper(field, index, element) {
    var inline = element.params.get('inputLabelInline', false) ? 1 : 0;

    this.attrs = [];
    this.options = [];
    this.optionsinline = 0;
    this.rows = 5;
    this.min_length = '';
    this.max_length = '';
    this.min = '';
    this.max = '';
    this.index = index;
    this.requiredMark = 0;
    var inputSize = element.params.get('inputSize', '');
    this.class = 'jdb-form-control' + (inputSize == '' ? '' : ' jdb-form-control-' + inputSize);
    this.labelclass = inline ? 'jdb-col-form-label jdb-col' + (inputSize == '' ? '' : ' jdb-col-form-label-' + inputSize) : 'jdb-form-label jdb-d-block';

    this.field = field;
    if (this.field.type != 'html') {
        this.name = this.field.name;
        this.id = element.id + '-' + this.name;
    }
    this.type = this.field.type;
    this.label = this.field.label;
    this.showLabel = 1;
    this.required = this.field.required ? 1 : 0;
    this.value = '';
    if (element.params.get('inputLabel', true)) {
        this.showLabel = this.label != '' ? 1 : 0;
    } else {
        this.showLabel = 0;
    }

    if (this.type == 'hidden') {
        this.showLabel = 0;
    }

    if (element.params.get('requiredMark', true)) {
        this.requiredMark = this.field.required ? 1 : 0;
    } else {
        this.requiredMark = 0;
    }

    if (this.requiredMark && (!this.showLabel || this.label == '')) {
        this.requiredMark = 0;
    }

    this.init = function () {
        switch (this.type) {
            case 'checkbox':
                this.showLabel = 0;
                if ('checked' in this.field && this.field.checked) {
                    this.attrs.push('checked="checked"');
                }
                break;
            case 'list':
                this.getOptions();
                if ('multiple' in this.field && this.field.multiple) {
                    this.attrs.push('multiple="true"');
                    this.name = this.name + '[]';
                }
                break;
            case 'radio':
            case 'checkboxes':
                this.getOptions();
                this.optionsinline = this.field.optionslayout == 'inline' ? 1 : 0;
                break;
            case 'textarea':
                this.rows = this.field.textarearows;
                if (this.field.placeholder) {
                    this.attrs.push('placeholder="' + this.field.placeholder + '"');
                }
                break;
            case 'html':
                this.content = this.field.content;
                break;
            case 'url':
                this.attrs.push('data-parsley-type="url"');
                if (this.field.placeholder) {
                    this.attrs.push('placeholder="' + this.field.placeholder + '"');
                }
                break;
            case 'email':
                this.attrs.push('data-parsley-type="email"');
                if (this.field.placeholder) {
                    this.attrs.push('placeholder="' + this.field.placeholder + '"');
                }
                break;
            case 'phone':
                this.attrs.push('jdb-phoneinput="format:0000000000;country: ' + (this.field.countryCodes ? 'true' : 'false') + '"');
                this.attrs.push('autocomplete="off"');
                this.attrs.push('data-parsley-phone-number');
                this.attrs.push('data-jdb-country-code');
                if (this.field.placeholder) {
                    this.attrs.push('placeholder="' + this.field.placeholder + '"');
                }
                this.countryCodes = this.field.countryCodes ? 1 : 0;
                break;
            case 'text':
            case 'password':
                if (('min_length' in this.field) && this.field.min_length != '') {
                    this.attrs.push('data-parsley-minlength="' + this.field.min_length + '"');
                }
                if (('max_length' in this.field) && this.field.max_length != '') {
                    this.attrs.push('data-parsley-maxlength="' + this.field.max_length + '"');
                }
                if (this.field.placeholder) {
                    this.attrs.push('placeholder="' + this.field.placeholder + '"');
                }
                break;
            case 'number':
                this.attrs.push('data-parsley-type="number"');
                if (('min_length' in this.field) && this.field.min_length != '') {
                    this.attrs.push('data-parsley-minlength="' + this.field.min_length + '"');
                }
                if (('max_length' in this.field) && this.field.max_length != '') {
                    this.attrs.push('data-parsley-maxlength="' + this.field.max_length + '"');
                }
                if (('min' in this.field) && this.field.min != '') {
                    this.attrs.push('data-parsley-min="' + this.field.min + '"');
                }
                if (('max' in this.field) && this.field.max != '') {
                    this.attrs.push('data-parsley-max="' + this.field.max + '"');
                }
                if (('step' in this.field) && this.field.step != '') {
                    this.attrs.push('step="' + this.field.step + '"');
                }
                if (this.field.placeholder) {
                    this.attrs.push('placeholder="' + this.field.placeholder + '"');
                }
                break;
            case 'calendar':
                if (this.field.placeholder) {
                    this.attrs.push('placeholder="' + this.field.placeholder + '"');
                }

                var options = [];

                if (('calendar_min_enable' in this.field) && this.field.calendar_min_enable && ('calendar_min' in this.field) && this.field.calendar_min != '') {
                    options.push('min:' + this.formatDate(this.field.calendar_min));
                }

                if (('calendar_max_enable' in this.field) && this.field.calendar_max_enable && ('calendar_max' in this.field) && this.field.calendar_max != '') {
                    options.push('max:' + this.formatDate(this.field.calendar_max));
                }

                if (('calendar_format' in this.field) && this.field.calendar_format != '') {
                    options.push('format:' + this.field.calendar_format);
                }

                this.attrs.push('jdb-datepicker="' + options.join(';') + '"');
                break;
        }
        this.value = this.field.value == undefined ? '' : this.field.value;
    };

    this.formatDate = function (ddmmyyyy) {
        ddmmyyyy = ddmmyyyy.split('/');
        return ddmmyyyy[2] + '-' + ddmmyyyy[0] + '-' + ddmmyyyy[1];
    }

    this.getOptions = function () {
        if (this.type == "radio" || this.type == "list" || this.type == "checkboxes") {
            var array = this.field.options.split("\n");
            var options = [];
            var id = this.id;
            array.forEach(function (item, index) {
                if (item !== '') {
                    options.push({
                        'value': item,
                        'id': id + '-' + index
                    });
                }
            });

            this.options = options;
        }
    }

    this.init();
    this.attributes = this.attrs.length ? ' ' + this.attrs.join(' ') : '';
}