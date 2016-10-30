<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'PathUpload' => dirname(dirname(dirname(__FILE__)))."/member/web/upload",
    'EventFilePathUpload' => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR. 'uploads'.DIRECTORY_SEPARATOR,
];
