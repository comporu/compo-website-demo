<?php

/*
 * This file is part of the CompoSymfonyCms package.
 * (c) Compo.ru <info@compo.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer;

require __DIR__ . '/vendor/comporu/compo-core/src/Compo/CoreBundle/Resources/recipe/compo.php';

inventory(__DIR__ . '/app/config/servers.yml');
