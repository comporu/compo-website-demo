<?php

/*
 * This file is part of the CompoSymfonyCms package.
 * (c) Compo.ru <info@compo.ru>
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
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $mediaManager = $this->getMediaManager();

        $banner = new Banner();

        $banner->setName('Main');
        $banner->setOptions('{
  centerMode: true,
  centerPadding: \'60px\',
  slidesToShow: 3,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: \'40px\',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: \'40px\',
        slidesToShow: 1
      }
    }
  ]
}');

        $media = new Media();
        $media->setBinaryContent(__DIR__ . '/../Resources/public/fixtures/banner_1.jpg');
        $media->setEnabled(true);
        $media->setName('banner_1.jpg');
        $media->setContext('default');
        $media->setProviderName('sonata.media.provider.image');
        $mediaManager->save($media, false);

        $bannerItem = new BannerItem();
        $bannerItem->setName('One');
        $bannerItem->setEnabled(true);
        $bannerItem->setTitle('One - Title');
        $bannerItem->setDescription('One - Description');
        $bannerItem->setUrl('');
        $bannerItem->setImage($media);

        $banner->addItem($bannerItem);

        $media = new Media();
        $media->setBinaryContent(__DIR__ . '/../Resources/public/fixtures/banner_2.png');
        $media->setEnabled(true);
        $media->setName('banner_2.png');
        $media->setContext('default');
        $media->setProviderName('sonata.media.provider.image');
        $mediaManager->save($media, false);

        $bannerItem = new BannerItem();
        $bannerItem->setName('Two');
        $bannerItem->setEnabled(true);
        $bannerItem->setTitle('Two - Title');
        $bannerItem->setDescription('Two - Description');
        $bannerItem->setUrl('http://compo.ru');
        $bannerItem->setImage($media);

        $banner->addItem($bannerItem);

        $manager->persist($banner);

        $manager->flush();
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getMediaManager()
    {
        return $this->container->get('sonata.media.manager.media');
    }
}
