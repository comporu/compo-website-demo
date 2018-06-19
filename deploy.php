<?php

namespace Deployer;

require __DIR__ . '/vendor/comporu/compo-core/src/Compo/CoreBundle/Resources/recipe/compo.php';

inventory(__DIR__ . '/app/config/servers.yml');
