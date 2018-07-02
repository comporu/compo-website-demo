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
        $bundles[] = new \Bazinga\Bundle\FakerBundle\BazingaFakerBundle();

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
