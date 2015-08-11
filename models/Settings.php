<?php namespace BnB\ScaffoldTranslation\Models;

use Model;

/**
 * Settings Model
 */
class Settings extends Model
{

    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'bnb_scaffoldtranslation_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

}