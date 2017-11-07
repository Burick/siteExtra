<?php
require_once 'build.class.php';
$resolvers = array(
    'providers',
    'addons',
    'rename_htaccess',
#    'remove_changelog',
    'cache_options',
    'template',
    'tvs',
    'resources',
    'settings',
    'set_start_year',
    'fix_translit',
    'manager_customisation'
);
$addons = array(
    array('name' => 'modx.com', 'packages' => array(
            'simpleUpdater'         => '0.1.0-beta',
            'FormIt'                => '2.2.10-pl',
            'autoRedirector'        => '0.1.0-beta',
            'CKEditor'              => '1.3.0-pl',
            'TinyMCE RTE'           => '1.2.0-pl',
            'AutoTemplate'          => '1.0.0-rc',
            'SEO Tab'               => '2.0.3-pl',
            'SEO Pro'               => '1.2.0-pl',
            'Batcher'               => '2.0.0-pl',
            #'Bloodline' => '2.0.0-pl',
            'Collections'           => '3.4.2-pl',
            'Console'               => '2.1.0-beta',
            'MIGX'                  => '2.11.0-pl',
            'Gallery'               => '1.7.0-pl',
            'translit'              => '1.0.0-beta',
            'filetranslit'          => '0.1.2-pl2',
            'FirstChildRedirect'    => '2.3.1-pl',
            'clientconfig'          => '1.4.2-pl',
            'VersionX'              => '2.1.3-pl'
        )),
    array('name' => 'modstore.pro', 'packages' => array(
            'Ace'               => '1.6.5-pl',
            'pdoTools'          => '2.8.6-pl',
            'Jevix'             => '1.2.2-pl',
            'Tickets'           => '1.8.1-pl',
            'AjaxForm'          => '1.1.5-pl',
            'MinifyX'           => '1.4.4-pl',
            'DateAgo'           => '1.0.4-pl',
            'phpThumbOn'        => '1.3.1-pl',
            'tagElementPlugin'  => '1.1.3-pl',
            'frontendManager'   => '1.0.8-beta',
            'FastUploadTV'      => '1.0.0-pl',
            'Compiler'          => '1.0.5-beta',
            'controlErrorLog'   => '1.1.2-pl',
            'modDevTools'       => '1.2.1-pl',
            'debugParser'       => '1.1.0-pl',
            'ChangePack'        => '1.2.0-beta',
            'modHelpers'        => '3.0.1-beta',

        )),

);
$builder = new siteBuilder('blank_fenom', '0.0.1', 'beta', $resolvers, $addons);
$builder->build();
