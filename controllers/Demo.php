<?php namespace BnB\ScaffoldTranslation\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Demo Back-end Controller
 */
class Demo extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BnB.ScaffoldTranslation', 'scaffoldtranslation', 'demo');
    }
}