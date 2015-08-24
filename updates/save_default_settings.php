<?php

use BnB\ScaffoldTranslation\Models\Settings;

class SaveDefaultSettings extends \October\Rain\Database\Updates\Seeder
{

    public function run()
    {
        Settings::set('default_mode', 1);
    }
}