<?php namespace BnB\ScaffoldTranslation\Classes\Templates;

use BnB\ScaffoldTranslation\Classes\TemplateBase;

class Widget extends TemplateBase
{

    /**
     * @var array A mapping of stub to generated file.
     */
    protected $fileMap = [
        'widget/widget.stub'     => 'widgets/{{studly_name}}.php',
        'widget/partial.stub'    => 'widgets/{{lower_name}}/_{{lower_name}}.htm',
        'widget/stylesheet.stub' => 'widgets/{{lower_name}}/assets/css/{{lower_name}}.css',
        'widget/javascript.stub' => 'widgets/{{lower_name}}/assets/js/{{lower_name}}.js',
    ];
}