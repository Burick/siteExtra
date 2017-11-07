<?php
/** @var modX $this->modx */
/** @var array $sources */

$templates = array();

$tmp = [
    // $this->config['PACKAGE_NAME'] => [
    //     'file' => 'Base',
    //     'description' => 'Тест'
    // ],
    'Base' => [
        'file' => 'Base',
        'description' => 'Базовый шаблон',
        'icon' => 'icon-window-maximize',

    ],
    'Main' => [
        'file' => 'Main',
        'description' => 'Главная',
        'icon' => 'icon-home',

    ],
   'Text' => [
        'file' => 'Text',
        'description' => 'Текстовая',
        'icon' => 'icon-file-word-o',

    ],
   'List' => [
        'file' => 'List',
        'description' => 'Список',
        'icon' => 'icon-list',

    ],            
];
$setted = false;
foreach ($tmp as $k => $v) {
    
    /** @var modtemplate $template */
    $template = $this->modx->newObject('modTemplate');
    $template->fromArray(array(
        'templatename' => $k,
        'category' => 0,
        'description' => @$v['description'],
        'icon' => @$v['icon'],
        //'content' => file_get_contents($this->config['PACKAGE_ROOT'] . 'core/components/'.strtolower($this->config['PACKAGE_NAME']).'/elements/templates/template.' . $v['file'] . '.html'),
        'static' => 1,
        'source' => 1,
        'static_file' => 'core/components/'.strtolower($this->config['PACKAGE_NAME']).'/elements/templates/template.' . $v['file'] . '.html',
    ), '', true, true);
    $templates[] = $template;
}
unset($tmp, $properties);

return $templates;