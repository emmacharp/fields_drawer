<?php

    class fieldFields_drawer extends Field {


    /*-------------------------------------------------------------------------
        Definition:
    -------------------------------------------------------------------------*/

        public function __construct(){
            parent::__construct();

            $this->_name = __('Fields drawer');
            $this->_required = false;
            $this->set('hide', 'no');
            $this->set('location', 'sidebar');
        }

    /*-------------------------------------------------------------------------
        Setup:
    -------------------------------------------------------------------------*/

        public function createTable(){
            return false;
        }

        public function requiresTable()
        {
            return false;
        }

    /*-------------------------------------------------------------------------
        Settings:
    -------------------------------------------------------------------------*/

        public function commit(){
            if(!parent::commit()) return false;

            $id = $this->get('id');

            if($id === false) return false;

            $fields = array();
            $fields['field_id'] = $id;
            $fields['open_by_default'] = empty($this->get('open_by_default')) ? 'no' : $this->get('open_by_default');

            return FieldManager::saveSettings($id, $fields);
        }

        public function buildSummaryBlock ($errors = null) {
            $div = new XMLElement('div');

            // Publish label
            $label = Widget::Label(__('Label'));
            $label->appendChild(
                Widget::Input('fields['.$this->get('sortorder').'][label]', $this->get('label'))
            );
            if (isset($errors['label'])) {
                $div->appendChild(Widget::Error($label, $errors['label']));
            } else {
                $div->appendChild($label);
            }

            $group = new XMLElement('div');

            $label = Widget::Label(__('Handle'));
            $label->setAttribute('class', 'column');

            $label->appendChild(Widget::Input('fields['.$this->get('sortorder').'][element_name]', $this->get('element_name')));

            if (isset($errors['element_name'])) {
                $group->appendChild(Widget::Error($label, $errors['element_name']));
            } else {
                $group->appendChild($label);
            }

            $div->appendChild($group);

            return $div;
        }

        public function displaySettingsPanel (XMLElement &$wrapper, $errors = null) {
            parent::displaySettingsPanel($wrapper, $errors);

            $div = new XMLElement('div', NULL, array('class' => 'two columns'));

            $label = Widget::Label();
            $label->setAttribute('class', 'column');
            $input = Widget::Input('fields['.$this->get('sortorder').'][open_by_default]', 'yes', 'checkbox');
            if($this->get('open_by_default') == 'yes') $input->setAttribute('checked', 'checked');
            $label->setValue(__('%s Open by default', array($input->generate())));

            $loc = new XMLElement('input');
            $loc->setAttribute('name', 'fields['.$this->get('sortorder').'][location]');
            $loc->setAttribute('value', 'sidebar');
            $loc->setAttribute('type', 'hidden');

            $div->appendChild($loc);
            $div->appendChild($label);

            $wrapper->appendChild($div);
        }

    /*-------------------------------------------------------------------------
        Publish:
    -------------------------------------------------------------------------*/

        public function displayPublishPanel(XMLElement &$wrapper, $data = NULL, $flagWithError = NULL, $fieldnamePrefix = NULL, $fieldnamePostfix = NULL, $entry_id = NULL){
            $wrapper->setAttribute('data-name', $this->get('label'));
            $wrapper->setAttribute('data-open', $this->get('open_by_default'));
            $wrapper->addClass('js-fields-drawer-hook');
            $wrapper->removeClass('field');
        }

        public function processRawFieldData($data, &$status, &$message = NULL, $simulate = false, $entry_id = NULL) {
            $status = self::__OK__;

            return array(
                'value' => ''
            );
        }

    /*-------------------------------------------------------------------------
        Output:
    -------------------------------------------------------------------------*/

        public function fetchIncludableElements() {
            return null;
        }

        public function appendFormattedElement(XMLElement &$wrapper, $data, $encode = false, $mode = NULL, $entry_id = NULL) {

        }

        public function prepareTextValue($data, $entry_id = null) {
            return '';
        }

    }
