<?php

return [
    'GET auth/<controller:[\w]+>/<action:[\w-]+>' => 'auth/can-access',
];
