<?php

namespace common\components\events;

use yii\i18n\MissingTranslationEvent;

class TranslationEventHandler
{
    public static function handleMissingTranslation(MissingTranslationEvent $event)
    {
        $event->translatedMessage = "<code>@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @</code>";
    }
}