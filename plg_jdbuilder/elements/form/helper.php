<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

use JDPageBuilder\ElementHelper as ElementHelper;
use JDPageBuilder\Helpers\SmartTags;

error_reporting(E_ALL & ~E_WARNING);

class JDBuilderFormElementHelper extends ElementHelper
{

    protected $_labels = [], $_values = [], $_fields = [], $_uploaded = [];

    public function submit()
    {
        $return = [];

        $return['server'] = $_SERVER;
        if (isset($_SERVER['CONTENT_LENGTH']) && (int) $_SERVER['CONTENT_LENGTH'] > ((int) ini_get('post_max_size') * 1024 * 1024)) {
            throw new \Exception(\JText::sprintf('JDB_FORM_ERROR_PHP_POST_LIMIT_EXCEED', \JFilesystemHelper::fileUploadMaxSize()));
        }

        if (!\JSession::checkToken()) {
            throw new \Exception(\JText::_('JDB_FORM_ERROR_BAD_REQUEST'));
        }

        if ($this->params->get('reCAPTCHA', false) && isset($_POST["g-recaptcha-response"])) {
            $buiderConfig = \JComponentHelper::getParams('com_jdbuilder');
            $recaptchaSecret = $buiderConfig->get('recaptchaSecretKey', '');
            $gResponse = $_POST["g-recaptcha-response"];

            $url = "https://www.google.com/recaptcha/api/siteverify";
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query(array(
                        'secret' => $recaptchaSecret,
                        'response' => $gResponse
                    ))
                )
            );
            $context  = stream_context_create($options);
            $captchaResponse = file_get_contents($url, false, $context);
            $captchaResponse = \json_decode($captchaResponse);
            if (!$captchaResponse->success) {
                throw new \Exception(\JText::_('JDB_FORM_ERROR_BAD_RECAPTCHA'));
            }
        }


        $this->uploads();
        $this->init();

        $actions = $this->params->get('afterSubmitAddAction', []);

        foreach ($actions as $action) {
            $action = JDPageBuilder\Helper::classify($action);
            $this->$action($return);
        }

        $return['message'] = $this->_tag($this->params->get('successMessage', ''));

        return $return;
    }

    public function init()
    {
        $fields = $this->params->get('fields', []);
        $jinput = \JFactory::getApplication()->input;
        foreach ($fields as $field) {
            $this->_labels[$field->name] = empty($field->label) ? $field->name : $field->label;
            if ($field->type == 'file') {
                $this->_values[$field->name] = isset($this->_uploaded[$field->name]) ? $this->_uploaded[$field->name]['filename'] : '';
            } else if ($field->type == 'checkbox') {
                $value = $jinput->post->get($field->name, '', 'RAW');
                $this->_values[$field->name] = ($value == 'on' ? 'Accepted' : 'Not Accepted');
            } else {
                $value = $jinput->post->get($field->name, '', 'RAW');
                $_value = null;
                switch (gettype($value)) {
                    case 'array':
                        $_value = implode(', ', $value);
                        break;
                    case 'object':
                        $_value = implode(', ', (array) $value);
                        break;
                    default:
                        $_value = $value;
                        break;
                }
                $this->_values[$field->name] = $_value;
            }
            $this->_fields[$field->name] = '<strong>' . $this->_labels[$field->name] . ':</strong> ' . $this->_values[$field->name];
        }
        $allfields = implode("<br/>", $this->_fields);
        $this->_fields['allfields'] = $allfields;
    }

    public function uploads()
    {
        $fields = $this->params->get('fields', []);
        $fileInputs = [];
        foreach ($fields as $field) {
            if ($field->type == 'file') {
                $extensions = isset($field->file_extensions) && !empty($field->file_extensions) ? explode(',', $field->file_extensions) : [];
                $maxSize = isset($field->max_file_size) && !empty($field->max_file_size) ? $field->max_file_size : 0;
                $fileInputs[$field->name] = [
                    'extensions' => $extensions,
                    'max_size' => $maxSize
                ];
            }
        }

        foreach ($_FILES as $key => $file) {
            if (!$file['error']) {
                $uploaded =  JDPageBuilder\Helper::uploadFile($file['name'], $file['tmp_name'], $file['size'], $fileInputs[$key]['extensions'], $fileInputs[$key]['max_size']);
                $this->_uploaded[$key] =  ['path' => $uploaded, 'filename' => basename($uploaded)];
            }
        }
    }

    public function _tag($text, $html = true)
    {
        $text = SmartTags::apply($text, ['fieldvalue' => $this->_values, 'fieldlabel' => $this->_labels, 'field' => $this->_fields]);
        if (!$html) {
            $text = strip_tags(str_replace('<br/>', "\n", $text));
        }
        return $text;
    }

    public function email(&$return)
    {
        $emailTo = $this->params->get('emailTo', '');
        $emailSubject = $this->params->get('emailSubject', '');
        if ($this->params->get('emailCustom', false)) {
            $emailBody = $this->params->get('emailCustomTemplate', '');
        } else {
            $emailMessage = $this->params->get('emailMessage', '');
            $emailFooter = $this->params->get('emailFooter', '');
            $emailBody = JDPageBuilder\Helper::renderMustacheTemplateByFile(__DIR__ . '/tmpl/email.html', ['body' => $emailMessage, 'footer' => $emailFooter]);
        }
        $emailFromEmail = $this->params->get('emailFromEmail', '');
        $emailFromName = $this->params->get('emailFromName', '');
        $emailReply = $this->params->get('emailReply', '');
        $emailCC = $this->params->get('emailCC', '');
        $emailBCC = $this->params->get('emailBCC', '');
        $html = $this->params->get('emailAs', 'html') == 'html' ? true : false;

        $attachments = [];
        if ($this->params->get('emailAttachments', true)) {
            foreach ($this->_uploaded as $attachment) {
                $attachments[] = $attachment['path'];
            }
        }

        $sent = JDPageBuilder\Helper::sendMail($this->_tag($emailFromEmail, $html), JDPageBuilder\Helper::emailExplode($this->_tag($emailTo, $html)), $this->_tag($emailSubject, $html), $this->_tag($this->_tag($emailBody, $html)), $attachments, $this->_tag($emailFromName, $html), JDPageBuilder\Helper::emailExplode($this->_tag($emailReply, $html)), JDPageBuilder\Helper::emailExplode($this->_tag($emailCC, $html)), JDPageBuilder\Helper::emailExplode($this->_tag($emailBCC, $html)), $html);
        $return['emailSent'] = $sent;
    }

    public function redirect(&$return)
    {
        $redirectUrl = $this->params->get('redirectURL', '');
        if (!empty($redirectUrl)) {
            $return['redirect'] = true;
            $return['redirectURL'] = $redirectUrl;
            $return['redirectDelay'] = $this->params->get('redirectDelay', 3000);
        } else {
            $return['redirect'] = false;
        }
    }

    public function confirmMail(&$return)
    {
        $emailTo = $this->params->get('confirmEmailTo', '');
        $emailSubject = $this->params->get('confirmEmailSubject', '');
        if ($this->params->get('confirmEmailCustom', false)) {
            $emailBody = $this->params->get('confirmEmailCustomTemplate', '');
        } else {
            $emailMessage = $this->params->get('confirmEmailMessage', '');
            $emailFooter = $this->params->get('confirmEmailFooter', '');
            $emailBody = JDPageBuilder\Helper::renderMustacheTemplateByFile(__DIR__ . '/tmpl/email.html', ['body' => $emailMessage, 'footer' => $emailFooter]);
        }
        $emailFromEmail = $this->params->get('confirmEmailFromEmail', '');
        $emailFromName = $this->params->get('confirmEmailFromName', '');
        $emailReply = $this->params->get('confirmEmailReply', '');
        $emailCC = $this->params->get('confirmEmailCC', '');
        $emailBCC = $this->params->get('confirmEmailBCC', '');
        $html = $this->params->get('confirmEmailAs', 'html') == 'html' ? true : false;

        $attachments = [];
        if ($this->params->get('confirmEmailAttachments', true)) {
            foreach ($this->_uploaded as $attachment) {
                $attachments[] = $attachment['path'];
            }
        }

        $sent = JDPageBuilder\Helper::sendMail($this->_tag($emailFromEmail, $html), JDPageBuilder\Helper::emailExplode($this->_tag($emailTo, $html)), $this->_tag($emailSubject, $html), $this->_tag($this->_tag($emailBody, $html)), $attachments, $this->_tag($emailFromName, $html), JDPageBuilder\Helper::emailExplode($this->_tag($emailReply, $html)), JDPageBuilder\Helper::emailExplode($this->_tag($emailCC, $html)), JDPageBuilder\Helper::emailExplode($this->_tag($emailBCC, $html)), $html);
        $return['confirmEmailSent'] = $sent;
    }

    public function webhook(&$return)
    {
        try {

            $data = [];
            $webhookURL = $this->params->get('webhookURL', '');
            if (empty($webhookURL)) {
                throw new \Exception(\JText::_('JDB_FORM_ERROR_BAD_INVALID_WEBHOOK'));
            }
            $webhookURL = $this->_tag($webhookURL, false);
            $webhookMethod = $this->params->get('webhookMethod', 'POST');
            if ($webhookMethod == 'POST') {
                $webhookData = $this->params->get('webhookData', []);
                foreach ($webhookData as $key => $value) {
                    $data[$this->_tag($value->key)] = $this->_tag($value->value);
                }
            }
            $return['webhook'] = true;
            $return['webhookResponse'] = JDPageBuilder\Helper::curlRequest($webhookURL, $webhookMethod, $data);
        } catch (\Exception $e) {
            $return['webhook'] = false;
            $return['webhookResponse'] = null;
        }
    }
}

class FieldHelper
{
    public $field, $id, $type, $name, $label, $options = [], $required, $optionsinline = 0, $rows, $min_length = '', $max_length = '', $min = '', $max = '', $attrs = [], $requiredMark = 0, $class = '';
    function __construct($field, $index, $element = null)
    {
        $inline = $element->params->get('inputLabelInline', false) ? 1 : 0;

        $this->field = $field;
        if ($this->field->type != 'html') {
            $this->name = $this->field->name;
            $this->id = $element->id . '-' . $this->name;
        }
        $this->type = $this->field->type;
        $this->label = $this->field->label;
        $this->index = $index;
        $this->showLabel = 1;
        $this->required = $this->field->required ? 1 : 0;
        $this->value = '';
        if ($element->params->get('inputLabel', true)) {
            $this->showLabel = $this->label != '' ? 1 : 0;
        } else {
            $this->showLabel = 0;
        }

        if ($element->params->get('requiredMark', true)) {
            $this->requiredMark = $this->field->required ? 1 : 0;
        } else {
            $this->requiredMark = 0;
        }

        if ($this->requiredMark && (!$this->showLabel || $this->label == '')) {
            $this->requiredMark = 0;
        }

        $inputSize = $element->params->get('inputSize', '');
        $this->class = 'jdb-form-control' . (empty($inputSize) ? '' : ' jdb-form-control-' . $inputSize);
        $this->labelclass = $inline ? 'jdb-col-form-label jdb-col' . ($inputSize == '' ? '' : ' jdb-col-form-label-' . $inputSize) : 'jdb-form-label jdb-d-block';

        $this->init();
    }

    function init()
    {
        switch ($this->type) {
            case 'checkbox':
                $this->showLabel = 0;
                if (isset($this->field->checked) && $this->field->checked) {
                    $this->attrs[] = 'checked';
                }
                break;
            case 'list':
                $this->getOptions();
                if (isset($this->field->multiple) && $this->field->multiple) {
                    $this->attrs[] = 'multiple="true"';
                    $this->name = $this->name . '[]';
                }
                break;
            case 'radio':
            case 'checkboxes':
                $this->getOptions();
                $this->optionsinline = $this->field->optionslayout == 'inline' ? 1 : 0;
                break;
            case 'textarea':
                $this->rows = $this->field->textarearows;
                $this->attrs[] = 'placeholder="' . @$this->field->placeholder . '"';
                break;
            case 'html':
                $this->content = @$this->field->content;
                break;
            case 'number':
                $this->attrs[] = 'data-parsley-type="number"';
                if (isset($this->field->min_length) && $this->field->min_length != '') {
                    $this->attrs[] = 'data-parsley-minlength="' . $this->field->min_length . '"';
                }
                if (isset($this->field->max_length) && $this->field->max_length != '') {
                    $this->attrs[] = 'data-parsley-maxlength="' . $this->field->max_length . '"';
                }
                if (isset($this->field->min) && $this->field->min != '') {
                    $this->attrs[] = 'data-parsley-min="' . $this->field->min . '"';
                }
                if (isset($this->field->max) && $this->field->max != '') {
                    $this->attrs[] = 'data-parsley-max="' . $this->field->max . '"';
                }
                if (isset($this->field->step) && $this->field->step != '') {
                    $this->attrs[] = 'step="' . $this->field->step . '"';
                }
                $this->attrs[] = 'placeholder="' . @$this->field->placeholder . '"';
                break;
            case 'url':
                $this->attrs[] = 'data-parsley-type="url"';
                $this->attrs[] = 'placeholder="' . @$this->field->placeholder . '"';
                break;
            case 'email':
                $this->attrs[] = 'data-parsley-type="email"';
                $this->attrs[] = 'placeholder="' . @$this->field->placeholder . '"';
                break;
            case 'phone':
                $this->attrs[] = 'jdb-phoneinput="format:0000000000;country: ' . (@$this->field->countryCodes ? 'true' : 'false') . '"';
                $this->attrs[] = 'autocomplete="off"';
                $this->attrs[] = 'data-parsley-phone-number';
                $this->attrs[] = 'data-jdb-country-code';
                $this->attrs[] = 'placeholder="' . @$this->field->placeholder . '"';
                $this->countryCodes = (@$this->field->countryCodes ? 1 : 0);
                break;
            case 'text':
            case 'password':
                if (isset($this->field->min_length) && $this->field->min_length != '') {
                    $this->attrs[] = 'data-parsley-minlength="' . $this->field->min_length . '"';
                }
                if (isset($this->field->max_length) && $this->field->max_length != '') {
                    $this->attrs[] = 'data-parsley-maxlength="' . $this->field->max_length . '"';
                }
                $this->attrs[] = 'placeholder="' . @$this->field->placeholder . '"';
                break;
            case 'calendar':
                \JDPageBuilder\Builder::addJavascript(\JURI::root() . 'media/jdbuilder/js/moment.min.js');
                \JDPageBuilder\Builder::addJavascript(\JURI::root() . 'media/jdbuilder/js/pikaday.min.js');
                $this->attrs[] = 'placeholder="' . @$this->field->placeholder . '"';

                $options = [];
                if (isset($this->field->calendar_min_enable) && $this->field->calendar_min_enable && isset($this->field->calendar_min) && $this->field->calendar_min != '') {
                    $options[] = 'min:' . $this->formatDate($this->field->calendar_min);
                }
                if (isset($this->field->calendar_max_enable) && $this->field->calendar_max_enable && isset($this->field->calendar_max) && $this->field->calendar_max != '') {
                    $options[] = 'max:' . $this->formatDate($this->field->calendar_max);
                }
                if (isset($this->field->calendar_format) && $this->field->calendar_format != '') {
                    $options[] = 'format:' . $this->field->calendar_format;
                }

                $this->attrs[] = 'jdb-datepicker="' . implode(';', $options) . '"';
                break;
                break;
        }
        $this->value = @$this->field->value;
    }

    function formatDate($ddmmyyyy)
    {
        $ddmmyyyy = explode('/', $ddmmyyyy);
        return $ddmmyyyy[2] . '-' . $ddmmyyyy[0] . '-' . $ddmmyyyy[1];
    }

    function getOptions()
    {
        if ($this->type == "radio" || $this->type == "list" || $this->type == "checkboxes") {
            $array = \explode("\n", $this->field->options);
            $options = [];
            foreach ($array as $index => $item) {
                if ($item !== '') {
                    $options[] = ['value' => $item, 'id' => $this->id . '-' . $index];
                }
            }
            $this->options = $options;
        }
    }
    function attributes()
    {
        if (!empty($this->attrs)) {
            return ' ' . implode(' ', $this->attrs);
        }
        return '';
    }
}
