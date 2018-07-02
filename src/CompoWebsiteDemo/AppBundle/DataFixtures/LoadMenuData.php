<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CompoWebsiteDemo\AppBundle\DataFixtures;


use Compo\MenuBundle\Entity\Menu;
use Compo\MenuBundle\Entity\MenuItem;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadPageData
 */
class LoadMenuData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 14;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getMediaManager()
    {
        return $this->container->get('sonata.media.manager.media');
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $menu = new Menu();
        $menu->setName('Main');

        $menuItem = new MenuItem();
        $menuItem->setName('Articles');
        $menuItem->setUrl('/articles/');
        $menuItem->setType('url');
        $menuItem->setEnabled(true);
        $menuItem->setMenu($menu);
        $manager->persist($menuItem);

        $menuItem = new MenuItem();
        $menuItem->setName('News');
        $menuItem->setUrl('/news/');
        $menuItem->setType('url');
        $menuItem->setEnabled(true);
        $menuItem->setMenu($menu);
        $manager->persist($menuItem);

        $menuItem = new MenuItem();
        $menuItem->setName('Faq');
        $menuItem->setUrl('/faq/');
        $menuItem->setType('url');
        $menuItem->setEnabled(true);
        $menuItem->setMenu($menu);
        $manager->persist($menuItem);


        $manager->persist($menu);

        $manager->flush();


        $settings = $this->container->get('sylius.settings_manager')->load('compo_core_settings');

        $settings->set('header_menu', 1);

        $this->container->get('sylius.settings_manager')->save($settings);

    }
}
