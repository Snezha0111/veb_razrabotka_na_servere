<?php
return [
    '~^$~'=> [\MyProject\Controllers\MainController::class, 'main'],
    '~^about/(.*)$~'=> [\MyProject\Controllers\MainController::class, 'aboutMe'],
    '~^bye/(.*)$~'=> [\MyProject\Controllers\MainController::class, 'sayBye'],  
    '~^hello/(.*)$~'=> [\MyProject\Controllers\MainController::class, 'sayHello'],
];