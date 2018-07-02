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

use Compo\BannerBundle\Entity\Banner;
use Compo\BannerBundle\Entity\BannerItem;
use Compo\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadPageData.
 */
class LoadBannerData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
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
        $mediaManager = $this->getMediaManager();

        $banner = new Banner();

        $banner->setName('Main');

        $bannerItem = new BannerItem();
        $bannerItem->setName('One');
        $bannerItem->setEnabled(true);
        $bannerItem->setBanner($banner);

        $media = new Media();
        $media->setBinaryContent(__DIR__ . '/../Resources/public/fixtures/banner_1.jpg');
        $media->setEnabled(true);
        $media->setName('banner_1.jpg');
        $media->setContext('default');
        $media->setProviderName('sonata.media.provider.image');
        $mediaManager->save($media, false);

        $bannerItem->setImage($media);

        $manager->persist($bannerItem);

        $bannerItem = new BannerItem();
        $bannerItem->setName('Two');
        $bannerItem->setEnabled(true);
        $bannerItem->setBanner($banner);

        $media2 = new Media();
        $media2->setBinaryContent(__DIR__ . '/../Resources/public/fixtures/banner_2.png');
        $media2->setEnabled(true);
        $media2->setName('banner_2.png');
        $media2->setContext('default');
        $media2->setProviderName('sonata.media.provider.image');
        $mediaManager->save($media2, false);

        $bannerItem->setImage($media2);

        $manager->persist($bannerItem);

        $manager->persist($banner);

        $manager->flush();
    }
}
