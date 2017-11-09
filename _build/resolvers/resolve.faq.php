<?php

/** @var $modx modX */
if (!$modx = $object->xpdo AND !$object->xpdo instanceof modX) {
    return true;
}
if( ! $modx->getService('tickets') ){
     $modx->log(modX::LOG_LEVEL_ERROR,'Не удалось создать Faq, Тикетс не установлен!'); //flush(); 
     return true;     
}
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
         $modx->log(modX::LOG_LEVEL_INFO,'Создается FAQ'); //flush();       
        /* FAQ */
        $alias = 'faq';
        $parent = 0;
        $template_name = 'List';
        $template = $modx
                        ->getObject('modTemplate', array('templatename' => $template_name))
                        ->get('id');


        if (!$resource = $modx->getObject('modResource', array('alias' => $alias))) {
            $resource = $modx->newObject('modResource');
        }

        $resource->fromArray(array(
            'class_key'    => 'modDocument',
            'menuindex'    => '',
            'pagetitle'    => 'FAQ',
            'longtitle'    => 'Часто задаваемые вопросы',
            'menutitle'    => 'ЧаВо',
            'alias'        => $alias,
            'uri'          => $alias . '.html',
            //'uri_override' => 0,
            'published'    => 1,
            'publishedon'  => time(),
            'hidemenu'     => 1,
            'richtext'     => 0,
            'parent'       => $parent,
            'template'     => $template,

            'searchable'   => 0,
            'content_type' => 1,
            'contentType'  => 'text/html',

            'content' => preg_replace(array('/^\n/', '/[ ]{2,}|[\t]/'), '', "
                <p>Ответы на самые популярные вопросы</p>
            ")
        ));
        $resource->save();


        $thread = $resource->get('pagetitle');
        //Проверяем есть ли тред , если нет то создаем
        if (!$threadObject = $modx->getObject('TicketThread', array('name' => $thread, 'deleted' => 0, 'closed' => 0))) {
            $threadObject = $modx->newObject('TicketThread');
            $threadObject->set('name', $thread);
            $threadObject->set('resource', $resource->get('id')/* $ticket['id']*/);
            $threadObject->save();
        }
        $thread = $threadObject->get('id'); 

        $review_count = 5; //Количество вопросов
        for ($i = 1; $i <= $review_count; $i++) {
            $review = [
                'review'    =>'
            <p>Деревни рукопись заголовок дорогу злых журчит lorem единственное но за даль ему возвращайся океана продолжил, имени, ты скатился моей? На берегу своего до силуэт проектах вопрос правилами послушавшись продолжил, подпоясал, власти?</p>
   
                ',   
                'reply'    =>'
            <p>Ответ на ваш супервопрос</p>    
                ',      
            ];
            
            
            $opt = [
                    'thread'    => $thread,
                    'parent'    => 0,
                    'raw'       => strip_tags($review['review'])?:'',
                    'text'      => $review['review']?:'',
                    'published' => 1,
                    'name'      => 'Ведите имя',
                    'email'     => 'email@email.user',
                    'createdby' => '0',
            ];
            
                /**
                */
                $TicketComment = $modx->newObject('TicketComment');
            
                $TicketComment->fromArray($opt, '', true, true);
                if( $TicketComment->save() ){
                    $parent_id = $TicketComment->get('id');
                }else{
                    $modx->log(modX::LOG_LEVEL_ERROR,'Коммент не создан!'); flush();
                }
            
                $opt = [
                        'thread'    => $thread,
                        'parent'    => $parent_id,
                        'raw'       => strip_tags($review['reply'])?:'',
                        'text'      => $review['reply']?:'',
                        'published' => 1,
                        'name'      => 'Администрация сайта '.$modx->getOption('site_name'),
                        'email'     => $modx->getOption('emailsender'),
                        'createdby' => '0',
                ];
            
                $TicketComment = $modx->newObject('TicketComment');
                $TicketComment->fromArray($opt, '', true, true);
                if( !$TicketComment->save() ) $modx->log(modX::LOG_LEVEL_ERROR,'Создание ответа к вопросу потерпело ошибку!'); flush();
            
        }
        break;    
    case xPDOTransport::ACTION_UPGRADE:
        $modx->log(modX::LOG_LEVEL_INFO,'Нет вопросов для обновления'); flush();
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}
return true;
