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

use Compo\AdvantagesBundle\Entity\Advantages;
use Compo\AdvantagesBundle\Entity\AdvantagesItem;
use Compo\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadPageData
 */
class LoadAdvantagesData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
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

        $advantages = new Advantages();

        $advantages->setName('Main');

        $advantagesData = [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four'
        ];

        foreach ($advantagesData as $id => $name) {
            $media = new Media();
            $media->setBinaryContent(__DIR__ . '/../Resources/public/fixtures/advantages_' . $id . '.png');
            $media->setEnabled(true);
            $media->setName('advantages_' . $id . '.png');
            $media->setContext('default');
            $media->setProviderName('sonata.media.provider.image');
            $mediaManager->save($media, false);

            $advantagesItem = new AdvantagesItem();
            $advantagesItem->setName($name);
            $advantagesItem->setEnabled(true);
            $advantagesItem->setAdvantages($advantages);
            $advantagesItem->setImage($media);

            $manager->persist($advantagesItem);
        }

        $manager->persist($advantages);

        $manager->flush();
    }
}
