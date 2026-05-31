<?php
return [
    '~^$~'=> [\MyProject\Controllers\MainController::class, 'main'],
    
    '~^about/(.*)$~'=> [\MyProject\Controllers\MainController::class, 'aboutMe'],
    '~^bye/(.*)$~'=> [\MyProject\Controllers\MainController::class, 'sayBye'],  
    '~^hello/(.*)$~'=> [\MyProject\Controllers\MainController::class, 'sayHello'],
    
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^articles/create$~' => [\MyProject\Controllers\ArticlesController::class, 'create'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/(\d+)/update$~'=> [\MyProject\Controllers\ArticlesController::class, 'update'],
];

