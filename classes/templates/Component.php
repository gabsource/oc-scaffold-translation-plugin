<?php namespace BnB\ScaffoldTranslation\Classes\Templates;

use BnB\ScaffoldTranslation\Classes\TemplateBase;

class Component extends TemplateBase
{

    /**
     * @var array A mapping of stub to generated file.
     */
    protected $fileMap = [
        'component/component.stub' => 'components/{{studly_name}}.php',
        'component/default.stub'   => 'components/{{lower_name}}/default.htm',
    ];
}