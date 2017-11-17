<?php

/** @var $modx modX */
if (!$modx = $object->xpdo AND !$object->xpdo instanceof modX) {
    return true;
}

/** @var $options */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        $site_start = $modx->getObject('modResource', $modx->getOption('site_start'));
        if ($site_start) {
            $site_start->set('hidemenu', true);
            $site_start->save();
        }
            
        /* robots.txt */
        $alias = 'robots';
        $parent = 0;
        $templateId = 0;
        if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
            $resource = $modx->newObject('modResource');
        }
        $resource->fromArray(array(
            'class_key'    => 'modDocument',
            'menuindex'    => 1010,
            'pagetitle'    => $alias . '.txt',
            'alias'        => $alias,
            'uri'          => $alias . '.txt',
            'uri_override' => 0,
            'published'    => 1,
            'publishedon'  => time(),
            'hidemenu'     => 1,
            'richtext'     => 0,
            'parent'       => $parent,
            'template'     => $templateId,

            'searchable'   => 0,
            'content_type' => 3,
            'contentType'  => 'text/plain',

            'content' => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
                User-agent: * 
                Disallow: /
                Disallow: /*.php$
                Disallow: /cgi-bin
                Disallow: /manager/ 
                Disallow: /assets/components/ 
                Disallow: /core/ 
                Disallow: /connectors/ 
                Disallow: /index.php 
                Disallow: *?
                Allow: /core/cache/phpthumb/*.jpeg
                Allow: /core/cache/phpthumb/*.png
                Allow: /core/cache/phpthumb/*.svg  


                Host: {\$_modx->config.http_host}

                Sitemap: {\$_modx->config.site_url}sitemap.xml
            ")
        ));
        $resource->save();

        //Получаем ID шаблонов
        $templates = [
             'Base' => '',
             'Main' => '',
             'Text' => '',
             'List' => '',
            ];
        foreach($templates as $name=>$id){
             if( $template = $modx->getObject('modTemplate', array('templatename' => $name)) ){
                 $templates[$name]= $template->get('id');
             }else{
                 echo 'них нету';
                 $modx->log(modX::LOG_LEVEL_INFO,'Нет шаблона '.$name); 
                 flush();
             }    
        } 
        // Получаем ID шаблона по умолчанию
        if (isset($options['site_template_name']) && !empty($options['site_template_name'])) {
            $template = $modx->getObject('modTemplate', array('templatename' => $options['site_template_name']));
        }
        if ($template) {
            $templateId = $template->get('id');
        } else {
            $templateId = $modx->getOption('default_template');
        }


        /* Главная */
        $alias = 'index';
        $parent = 0;
        if ( $resource = $modx->getObject('modResource', array('id' => '1')) ){
            $resource->fromArray(array(
                'class_key'   => 'modDocument',
                'content'     => '
                    <p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Но мир дороге буквенных последний он ты переулка сбить раз, переписывается использовало инициал решила грамматики встретил толку подпоясал грустный до.</p>
                    <p>Переписали встретил образ оксмокс заглавных щеке над, на берегу злых своих строчка послушавшись домах знаках которое, ipsum коварный свой дал предупредила снова диких заманивший запятой. Первую агенство возвращайся жаренные единственное буквоград.</p>
                    <p>Парадигматическая, свою безорфографичный она несколько страну за пояс составитель по всей, языкового предупреждал грустный рыбными вопроса, жизни вдали образ мир журчит назад семь своих! Имени рот, взгляд там силуэт рыбными большого.</p>
                    <p>Ты свое рот путь толку послушавшись? Напоивший о переписывается, рукопись свою. Одна за пустился деревни заголовок это. Строчка маленький текста коварных семь, грамматики, взгляд послушавшись что текстами ты, переписывается заглавных.</p>
                    <p>Рыбными даль снова заманивший ему предупредила то рукопись большого свою, вопроса живет коварный всеми маленькая, пор даже на берегу последний образ однажды буквоград пустился повстречался. Даль, скатился пояс которое рукопись одна.</p>
                ',
                'menuindex'    => 10,
                'pagetitle'    => 'Главная',
                'menutitle'    => 'Главная',
                'isfolder'     => 0,
                'alias'        => 'index',
                'uri'          => '/',
                'uri_override' => 0,
                'published'    => 1,
                'publishedon'  => time(),
                'hidemenu'     => 1,
                'richtext'     => 1,
                'parent'       => $parent,
                'template'     => $templates['Main']
            ));
            $resource->save();            
        }
 




        /* О компании */
        $alias = 'about';
        $parent = 0;
        if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
            $resource = $modx->newObject('modResource');
            $resource->set('content', preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
                <p>Медиабизнес слабо допускает конструктивный формирование имиджа, учитывая результат предыдущих медиа-кампаний. Конвесия покупателя, конечно, по-прежнему востребована. Рыночная информация стабилизирует пресс-клиппинг, полагаясь на инсайдерскую информацию. План размещения без оглядки на авторитеты не так уж очевиден.</p>
                <p>Психологическая среда индуцирует конструктивный стратегический маркетинг, оптимизируя бюджеты. Медиапланирование поддерживает общественный ребрендинг. Медиамикс правомочен. Медиапланирование стабилизирует стратегический рекламоноситель.</p>
                <p>Рекламная площадка усиливает медиабизнес. Эволюция мерчандайзинга притягивает департамент маркетинга и продаж, оптимизируя бюджеты. Поэтому таргетирование стремительно усиливает целевой трафик. Потребление, вопреки мнению П.Друкера, редко соответствует рыночным ожиданиям. Имидж, следовательно, программирует медиамикс.</p>
            "));
        }
        $resource->fromArray(array(
            'class_key'    => 'modDocument',
            'menuindex'    => 20,
            'pagetitle'    => 'Информация о нас',
            'menutitle'    => 'О компании',
            'isfolder'     => 1,
            'alias'        => $alias,
            'uri'          => $alias . '/',
            'uri_override' => 0,
            'published'    => 1,
            'publishedon'  => time(),
            'hidemenu'     => 0,
            'richtext'     => 1,
            'parent'       => $parent,
            'template'     => $templates['Text']
        ));
        $resource->save();

        /* Новости */
        $alias = 'news';
        $parent = 0;
        $addNews = false;
        if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
            $resource = $modx->newObject('modResource');
            $addNews = true;
        }
        if (in_array('Collections', $options['install_addons'])) {
            $collection_type = 'CollectionContainer';
        } else {
            $collection_type = 'modDocument';
        }
        $resource->fromArray(array(
            'class_key'    => $collection_type,
            'menuindex'    => 5,
            'pagetitle'    => 'Новости компании',
            'menutitle'    => 'Новости',
            'isfolder'     => 1,
            'alias'        => $alias,
            'uri'          => $alias . '/',
            'uri_override' => 0,
            'published'    => 1,
            'publishedon'  => time(),
            'hidemenu'     => 0,
            'richtext'     => 1,
            'parent'       => $parent,
            'template'     => $templateId,
            'content'      => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
                <p></p>
            ")
        ));
        $resource->save();
        $newsAlias = $alias;
        
        $chunks = array(
                'aside'
            );
        foreach ($chunks as $chunk_name) {
            if ($chunk = $modx->getObject('modChunk', array('name' => $chunk_name))) {
                $chunk->set('snippet', str_replace('SITE_NEWS_ID', $resource->id, $chunk->snippet));
                $chunk->save();
            }
        }
        
        if ($addNews) {
            $newsParent = $resource->get('id');
            $news = array(
                "<p>Кризис жанра дает фузз, потому что современная музыка не запоминается. Очевидно, что нота заканчивает самодостаточный контрапункт контрастных фактур. Показательный пример – хамбакер неустойчив. Аллюзийно-полистилистическая композиция иллюстрирует дискретный шоу-бизнес. Как было показано выше, хамбакер продолжает звукоряд, таким образом объектом имитации является число длительностей в каждой из относительно автономных ритмогрупп ведущего голоса.</p>",
                "<p>В заключении добавлю, open-air дает конструктивный флажолет. Гипнотический рифф вызывает рок-н-ролл 50-х, благодаря быстрой смене тембров (каждый инструмент играет минимум звуков). Процессуальное изменение имеет определенный эффект \"вау-вау\". В заключении добавлю, процессуальное изменение выстраивает изоритмический цикл. Микрохроматический интервал, на первый взгляд, использует open-air, это понятие создано по аналогии с термином Ю.Н.Холопова \"многозначная тональность\".</p>",
                "<p>Соноропериод многопланово трансформирует длительностный голос. Серпантинная волна иллюстрирует разнокомпонентный сет. Иными словами, фишка всекомпонентна. Микрохроматический интервал неустойчив. Процессуальное изменение представляет собой мнимотакт. Как было показано выше, адажио продолжает флажолет.</p>"
            );
            for ($i = 1; $i <= 3; $i++) {
                /* Новость 1 */
                $alias = 'news-' . $i;
                if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
                    $resource = $modx->newObject('modResource');
                }
                $newsText = $news[$i-1] ? $news[$i-1] : $news[0];
                $resource->fromArray(array(
                    'class_key'    => 'modDocument',
                    'show_in_tree' => 0,
                    'menuindex'    => $i,
                    'pagetitle'    => 'Новость ' . $i,
                    'isfolder'     => 0,
                    'alias'        => $alias,
                    'uri'          => $newsAlias . '/' . $alias . '.html',
                    'uri_override' => 0,
                    'published'    => 1,
                    'publishedon'  => time() - 60 * 60 * $i,
                    'hidemenu'     => 0,
                    'richtext'     => 1,
                    'parent'       => $newsParent,
                    'template'     => $templateId,
                    'content'      => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', $newsText)
                ));
                $resource->save();
            }
        }

        /* Контактная информация */
        $alias = 'contacts';
        $parent = 0;
        if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
            $resource = $modx->newObject('modResource');
        }
        $resource->fromArray(array(
            'class_key'    => 'modDocument',
            'menuindex'    => 6,
            'pagetitle'    => 'Контактная информация',
            'isfolder'     => 1,
            'alias'        => $alias,
            'uri'          => $alias . '/',
            'uri_override' => 0,
            'published'    => 1,
            'publishedon'  => time(),
            'hidemenu'     => 0,
            'richtext'     => 0,
            'parent'       => $parent,
            'template'     => $templateId,
            'content'      => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', '
                <p>Адрес: {$_modx->resource.address}</p>
                <p>Телефон: {$_modx->resource.phone}</p>
                <p>E-mail: {$_modx->resource.email}</p>
                {$_modx->getChunk(\'contact_form\', [
                  \'form\' => \'form.contact_form\',
                  \'tpl\' => \'tpl.contact_form\',
                  \'subject\' => \'Сообщение с сайта \' ~ $_modx->config.site_url,
                  \'validate\' => \'name:required,phone:required,check:required\'
                ])}
            ')
        ));
        $resource->save();
        
        $chunks = array(
                'header',
                'contact_form'
            );
        foreach ($chunks as $chunk_name) {
            if ($chunk = $modx->getObject('modChunk', array('name' => $chunk_name))) {
                $chunk->set('snippet', str_replace('SITE_CONTACTS_ID', $resource->id, $chunk->snippet));
                $chunk->save();
            }
        }
        
        if (!$resource->getTVValue('address')) {
            $resource->setTVValue('address', 'г. Москва, ул. Печатников, д. 17, оф. 350');
        }
        if (!$resource->getTVValue('phone')) {
            $resource->setTVValue('phone', '+7 (499) 150-22-22');
        }
        if (!$resource->getTVValue('email')) {
            $resource->setTVValue('email', 'info@company.ru');
        }

        /* 404 */
        $alias = '404';
        $parent = 0;
        if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
            $resource = $modx->newObject('modResource');
        }
        $resource->fromArray(array(
            'class_key'    => 'modDocument',
            'menuindex'    => 1001,
            'pagetitle'    => 'Страница не найдена',
            'longtitle'    => '&nbsp;',
            'isfolder'     => 1,
            'alias'        => $alias,
            'uri'          => $alias . '/',
            'uri_override' => 0,
            'published'    => 1,
            'publishedon'  => time(),
            'hidemenu'     => 1,
            'richtext'     => 0,
            'parent'       => $parent,
            'template'     => $templateId,
            'content'      => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
                <div style='width: 500px; margin: -30px auto 0; overflow: hidden;padding-top: 25px;'>
                    <div style='float: left; width: 100px; margin-right: 50px; font-size: 75px;margin-top: 45px;'>404</div>
                    <div style='float: left; width: 350px; padding-top: 30px; font-size: 14px;'>
                        <h2>Страница не найдена</h2>
                        <p style='margin: 8px 0 0;'>Страница, на которую вы зашли, вероятно, была удалена с сайта, либо ее здесь никогда не было.</p>
                        <p style='margin: 8px 0 0;'>Возможно, вы ошиблись при наборе адреса или перешли по неверной ссылке.</p>
                        <h3 style='margin: 15px 0 0;'>Что делать?</h3>
                        <ul style='margin: 5px 0 0 15px;'>
                            <li>проверьте правильность написания адреса,</li>
                            <li>перейдите на <a href='{\$_modx->config.site_url}'>главную страницу</a> сайта,</li>
                            <li>или <a href='javascript:history.go(-1);'>вернитесь на предыдущую страницу</a>.</li>
                        </ul>
                    </div>
                </div>
            ")
        ));
        $resource->save();
        $res404 = $resource->get('id');
        
        /* HTML карта сайта */
        $alias = 'site-map';
        $parent = 0;
        if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
            $resource = $modx->newObject('modResource');
        }
        $resource->fromArray(array(
            'class_key'    => 'modDocument',
            'menuindex'    => 1000,
            'pagetitle'    => 'Карта сайта',
            'isfolder'     => 1,
            'alias'        => $alias,
            'uri'          => $alias . '/',
            'uri_override' => 0,
            'published'    => 1,
            'publishedon'  => time(),
            'hidemenu'     => 1,
            'richtext'     => 0,
            'parent'       => $parent,
            'template'     => $templateId,
            'content'      => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
                {'pdoMenu' | snippet : [
                    'startId' => 0,
                    'ignoreHidden' => 1,
                    'resources' => '-".$res404.",-' ~ \$_modx->resource.id,
                    'level' => 2,
                    'outerClass' => '',
                    'firstClass' => '',
                    'lastClass' => '',
                    'hereClass' => '',
                    'where' => '{\"searchable\":1}'
                ]}
            ")
        ));
        $resource->save();

        /* sitemap.xml */
        $alias = 'sitemap';
        $parent = 0;
        $templateId = 0;
        if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
            $resource = $modx->newObject('modResource');
        }
        $resource->fromArray(array(
            'class_key'    => 'modDocument',
            'menuindex'    => 1011,
            'pagetitle'    => $alias . '.xml',
            'alias'        => $alias,
            'uri'          => $alias . '.xml',
            'uri_override' => 0,
            'published'    => 1,
            'publishedon'  => time(),
            'hidemenu'     => 1,
            'richtext'     => 0,
            'parent'       => $parent,
            'template'     => $templateId,

            'searchable'   => 0,
            'content_type' => 2,
            'contentType'  => 'text/xml',

            'content' => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
                {'pdoSitemap' | snippet : [ 'showHidden' => 1, 'resources' => '-{$res404}' ]}
            ")
        ));
        $resource->save();
        
        
        
        
        $chunks = array(
                'head'
            );
        foreach ($chunks as $chunk_name) {
            if ($chunk = $modx->getObject('modChunk', array('name' => $chunk_name))) {
                $snippet = $chunk->snippet;
                $snippet = str_replace('SITE_FOLDER_NAME', strtolower($options['site_template_name']), $snippet);
                $snippet = str_replace('ASSETS_URL', $modx->getOption('assets_url'), $snippet);
                $chunk->set('snippet', $snippet);
                $chunk->save();
            }
        }
        if ($plugin = $modx->getObject('modPlugin', array('name' => 'addManagerCss'))) {
            $plugincode = $plugin->plugincode;
            $plugincode = str_replace('SITE_FOLDER_NAME', strtolower($options['site_template_name']), $plugincode);
            $plugin->set('plugincode', $plugincode);
            $plugin->save();
        }
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return true;








        // /* Галерея */
        // $alias = 'gallery';
        // $parent = 0;
        // $addPhotos = false;
        // if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
        //     $resource = $modx->newObject('modResource');
        //     $addPhotos = true;
        // }
        // $resource->fromArray(array(
        //     'class_key'    => 'modDocument',
        //     'menuindex'    => 4,
        //     'pagetitle'    => 'Галерея',
        //     'isfolder'     => 1,
        //     'alias'        => $alias,
        //     'uri'          => $alias . '/',
        //     'uri_override' => 0,
        //     'published'    => 1,
        //     'publishedon'  => time(),
        //     'hidemenu'     => 0,
        //     'richtext'     => 1,
        //     'parent'       => $parent,
        //     'template'     => $templateId,
        //     'content'      => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
        //         <p></p>
        //     ")
        // ));
        // $resource->save();
        
        // $chunks = array(
        //         'block.gallery'
        //     );
        // foreach ($chunks as $chunk_name) {
        //     if ($chunk = $modx->getObject('modChunk', array('name' => $chunk_name))) {
        //         $chunk->set('snippet', str_replace('SITE_GALLERY_ID', $resource->id, $chunk->snippet));
        //         $chunk->save();
        //     }
        // }
        
        // if ($addPhotos && in_array('MIGX', $options['install_addons'])) {
        //     $resource->setTVValue('elements', $modx->toJSON(
        //             array(
        //                 array('MIGX_id' => 1, 'img' => $modx->getOption('assets_url') . 'components/' . strtolower($options['site_category']) . '/web/img/gal1.jpg', 'title' => 'Фото 1'),
        //                 array('MIGX_id' => 2, 'img' => $modx->getOption('assets_url') . 'components/' . strtolower($options['site_category']) . '/web/img/gal2.jpg', 'title' => 'Фото 2'),
        //                 array('MIGX_id' => 3, 'img' => $modx->getOption('assets_url') . 'components/' . strtolower($options['site_category']) . '/web/img/gal3.jpg', 'title' => 'Фото 3'),
        //                 array('MIGX_id' => 4, 'img' => $modx->getOption('assets_url') . 'components/' . strtolower($options['site_category']) . '/web/img/gal4.jpg', 'title' => 'Фото 4'),
        //                 array('MIGX_id' => 5, 'img' => $modx->getOption('assets_url') . 'components/' . strtolower($options['site_category']) . '/web/img/gal5.jpg', 'title' => 'Фото 5'),
        //                 array('MIGX_id' => 6, 'img' => $modx->getOption('assets_url') . 'components/' . strtolower($options['site_category']) . '/web/img/gal6.jpg', 'title' => 'Фото 6'),
        //             )
        //         ));
        // }






        // /* Специалисты */
        // $alias = 'specialists';
        // $parent = 0;
        // $addspecs = false;
        // if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
        //     $resource = $modx->newObject('modResource');
        //     $addspecs = true;
        // }
        // $resource->fromArray(array(
        //     'class_key'    => 'modDocument',
        //     'menuindex'    => 30,
        //     'pagetitle'    => 'Наши сотрудники',
        //     'menutitle'    => 'Специалисты',
        //     'isfolder'     => 1,
        //     'alias'        => $alias,
        //     'uri'          => $alias . '/',
        //     'uri_override' => 0,
        //     'published'    => 1,
        //     'publishedon'  => time(),
        //     'hidemenu'     => 0,
        //     'richtext'     => 0,
        //     'parent'       => $parent,
        //     'template'     => $templateId,
        //     'content'      => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
        //         <p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Рыбными предложения подпоясал выйти, по всей пояс семь свой несколько первую предупредила пунктуация однажды, гор, возвращайся рот вопрос рыбного там взгляд!</p>

        //         <p>Которой прямо, это залетают предупреждал рот пор маленький продолжил. Подзаголовок продолжил буквоград, себя парадигматическая агенство дорогу образ составитель. Маленький жаренные предупреждал агенство лучше если, имени вскоре приставка свою все текстов?</p>

        //         <p>Последний своих вскоре единственное приставка, себя бросил толку безорфографичный ему деревни текста жаренные на берегу коварный обеспечивает имеет рукопись снова меня? Своего запятой послушавшись, букв рукопись диких текстов несколько если маленький.</p>
        //     ")
        // ));
        // $resource->save();
        // $specAlias = $alias;


        
        // $chunks = array(
        //         'aside',
        //         'content'
        //     );
        // foreach ($chunks as $chunk_name) {
        //     if ($chunk = $modx->getObject('modChunk', array('name' => $chunk_name))) {
        //         $chunk->set('snippet', str_replace('SITE_SPECS_ID', $resource->id, $chunk->snippet));
        //         $chunk->save();
        //     }
        // }
 


        // if ($addspecs) {
        //     $resource->setTVValue('show_on_page', 'content||gallery');
        //     $specParent = $resource->get('id');
        //     $positions = array(
        //         'Маркетолог',
        //         'Маркетолог',
        //         'PR-менеджер',
        //         'Директор',
        //         'Оператор колл-центра'
        //     );
        //     for ($i = 1; $i <= 5; $i++) {
        //         /* Специалист 1 */
        //         $alias = 'spec-' . $i;
        //         if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
        //             $resource = $modx->newObject('modResource');
        //         }
        //         $resource->fromArray(array(
        //             'class_key'    => 'modDocument',
        //             'menuindex'    => $i,
        //             'pagetitle'    => 'Сотрудник ' . $i,
        //             'isfolder'     => 0,
        //             'alias'        => $alias,
        //             'uri'          => $specAlias . '/' . $alias . '.html',
        //             'uri_override' => 0,
        //             'published'    => 1,
        //             'publishedon'  => time() - 60 * 60 * $i,
        //             'hidemenu'     => 0,
        //             'richtext'     => 1,
        //             'parent'       => $specParent,
        //             'template'     => $templateId,
        //             'content'      => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
        //                 <p>Журчит, своих снова свою силуэт ты. Несколько даже повстречался гор его последний своих себя решила осталось ты деревни алфавит маленькая приставка знаках своих эта, города моей языкового щеке власти встретил!</p>

        //                 <p>Деревни рукопись заголовок дорогу злых журчит lorem единственное но за даль ему возвращайся океана продолжил, имени, ты скатился моей? На берегу своего до силуэт проектах вопрос правилами послушавшись продолжил, подпоясал, власти?</p>

        //                 <p>Щеке повстречался грамматики составитель домах строчка, семантика по всей алфавит правилами всемогущая свой большого, встретил себя ipsum взгляд меня буквоград предложения. Даль дал назад взобравшись взгляд курсивных маленький рыбными, не одна?</p>

        //             ")
        //         ));
        //         $resource->save();
        //         $resource->setTVValue('img', $modx->getOption('assets_url') . 'components/' . strtolower($options['site_category']) . '/web/img/spec' . $i . '.png');
        //         $resource->setTVValue('subtitle', $positions[$i-1]);
        //     }
        // }


