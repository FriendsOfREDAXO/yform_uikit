<?php

$notices = [];
if ($this->getElement('notice') != '') {
    $notices[] = rex_i18n::translate($this->getElement('notice'), false);
}
if (isset($this->params['warning_messages'][$this->getId()]) && !$this->params['hide_field_warning_messages']) {
    $notices[] = '<span class="text-warning">' . rex_i18n::translate($this->params['warning_messages'][$this->getId()]) . '</span>'; //    var_dump();
}

$notice = '';
if (count($notices) > 0) {
    $notice = '<p class="help-block">' . implode('<br />', $notices) . '</p>';
}

$class_group = trim('form-group yform-element ' . $this->getWarningClass());

$class_label[] = 'uk-form-label';
$field_before = '';
$field_after = '';

if (trim($this->getElement('grid')) != '') {
    $grid = explode(',', trim($this->getElement('grid')));

    if (isset($grid[0]) && $grid[0] != '') {
        $class_label[] = trim($grid[0]);
    }

    if (isset($grid[1]) && $grid[1] != '') {
        $field_before = '<div class="' . trim($grid[1]) . '">';
        $field_after = '</div>';
    }
}

$output = $format;

$search = [];
$replace = [];

$pos = strpos($format, 'YYYY');
if ($pos !== false) {
    $replace_i = '<div><select class="' . trim('form-control uk-select ' . $this->getWarningClass()) . '" id="' . $this->getFieldId('year') . '" name="' . $this->getFieldName('year') . '">';
    $replace_i .= '<option value="00">--</option>';
    for ($i = $yearStart; $i <= $yearEnd; ++$i):
        $selected = (@$year == $i) ? ' selected="selected"' : '';
    $replace_i .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
    endfor;
    $replace_i .= '</select></div>';
    $replace['YYYY'] = $replace_i;
    $search[] = 'YYYY';
}

$pos = strpos($format, 'MM');
if ($pos !== false) {
    $replace_i = '<div><select class="' . trim('form-control uk-select ' . $this->getWarningClass()) . '" id="' . $this->getFieldId('month') . '" name="' . $this->getFieldName('month') . '">';
    $replace_i .= '<option value="00">--</option>';
    for ($i = 1; $i < 13; ++$i):
        $selected = (@$month == $i) ? ' selected="selected"' : '';
    $replace_i .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
    endfor;
    $replace_i .= '</select></div>';
    $replace['MM'] = $replace_i;
    $search[] = 'MM';
}

$pos = strpos($format, 'DD');
if ($pos !== false) {
    $replace_i = '<div><select class="' . trim('form-control uk-select ' . $this->getWarningClass()) . '" id="' . $this->getFieldId('day') . '" name="' . $this->getFieldName('day') . '">';
    $replace_i .= '<option value="00">--</option>';
    for ($i = 1; $i < 32; ++$i):
        $selected = (@$day == $i) ? ' selected="selected"' : '';
    $replace_i .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
    endfor;
    $replace_i .= '</select></div>';
    $replace['DD'] = $replace_i;
    $search[] = 'DD';
}

$pos = strpos($format, 'HH');
if ($pos !== false) {
    $replace_i = '<div><select class="' . trim('form-control uk-select ' . $this->getWarningClass()) . '" id="' . $this->getFieldId('hour') . '" name="' . $this->getFieldName('hour') . '">';
    foreach ($hours as $i):
        $selected = (@$hour == $i) ? ' selected="selected"' : '';
    $replace_i .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
    endforeach;
    $replace_i .= '</select></div>';
    $replace['HH'] = $replace_i;
    $search[] = 'HH';
}

$pos = strpos($format, 'ii');
if ($pos !== false) {
    $replace_i = '<div><select class="' . trim('form-control uk-select ' . $this->getWarningClass()) . '" id="' . $this->getFieldId('minute') . '" name="' . $this->getFieldName('minute') . '">';
    foreach ($minutes as $i):
        $selected = (@$minute == $i) ? ' selected="selected"' : '';
    $replace_i .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
    endforeach;
    $replace_i .= '</select></div>';
    $replace['ii'] = $replace_i;
    $search[] = 'ii';
}

$pos = strpos($format, 'ss');
if ($pos !== false) {
    $replace_i = '<div><select class="' . trim('form-control uk-select ' . $this->getWarningClass()) . '" id="' . $this->getFieldId('second') . '" name="' . $this->getFieldName('second') . '">';
    for ($i = 0; $i < 60; ++$i):
        $selected = (@$second == $i) ? ' selected="selected"' : '';
    $replace_i .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
    endfor;
    $replace_i .= '</select></div>';
    $replace['ss'] = $replace_i;
    $search[] = 'ss';
}

// $output = str_replace($search, $replace, $output);
$output = strtr($output, $replace);

echo '
    <div class="' . $class_group . '" id="' . $this->getHTMLId() . '">
        <label class="' . implode(' ', $class_label) . '" for="' . $this->getFieldId() . '">' . $this->getLabel() . '</label>
        ' . $field_before . '<div class="form-inline uk-grid-small" uk-grid>' . $output . '</div>' . $notice . $field_after . '
    </div>
';
