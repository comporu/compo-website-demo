<?php

use Compo\CoreBundle\Kernel\AppKernel as CoreKernel;

/** @noinspection PhpUndefinedClassInspection */

/**
 * {@inheritdoc}
 */
class AppKernel extends CoreKernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = parent::registerBundles();

        $bundles[] = new \CompoWebsiteDemo\AppBundle\AppBundle();

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectName()
    {
        return 'CompoWebsiteDemo';
    }
}
