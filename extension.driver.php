<?php
    /*
    Copyright: Deux Huit Huit 2018
    License: MIT, see the LICENCE file
    http://deuxhuithuit.mit-license.org/
    */

    if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");

    class extension_fields_drawer extends Extension {

        const EXT_NAME = 'Fields Drawer';
        const SETTING_GROUP = 'fields-drawer';

        protected $errors = array();

        public function getSubscribedDelegates(){
            return array(
                array(
                    'page' => '/backend/',
                    'delegate' => 'InitaliseAdminPageHead',
                    'callback' => 'appendToHead'
                ),
            );
        }

        public function appendToHead(Array $context) {
            $c = Administration::instance()->getPageCallback();

            // publish page
            if($c['driver'] == 'publish'){
                Administration::instance()->Page->addStylesheetToHead(URL . '/extensions/fields_drawer/assets/publish.fields_drawer.css');
                Administration::instance()->Page->addScriptToBody(URL . '/extensions/fields_drawer/assets/publish.fields_drawer.js');
            }
        }

        public function install() {
            return Symphony::Database()
                ->create('tbl_fields_fields_drawer')
                ->ifNotExists()
                ->fields([
                    'id' => [
                        'type' => 'int(11)',
                        'auto' => true,
                    ],
                    'field_id' => 'int(11)',
                    'open_by_default' => [
                        'type' => 'enum',
                        'values' => ['yes','no'],
                        'default' => 'no',
                    ],
                ])
                ->keys([
                    'id' => 'primary',
                ])
                ->execute()
                ->success();
        }

        public function update($previousVersion = false) {
            return true;
        }

        public function uninstall() {
            return  Symphony::Database()
                ->drop('tbl_fields_fields_drawer')
                ->ifExists()
                ->execute()
                ->success();
        }

    }
