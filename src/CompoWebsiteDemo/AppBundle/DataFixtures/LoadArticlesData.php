<?php

/*
 * This file is part of the CompoSymfonyCms package.
 * (c) Compo.ru <info@compo.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CompoWebsiteDemo\AppBundle\DataFixtures;

use Compo\ArticlesBundle\Entity\Articles;
use Compo\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadPageData.
 */
class LoadArticlesData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
        $faker = $this->getFaker();
        $mediaManager = $this->getMediaManager();

        $count = random_int(25, 35);

        for ($i = 1; $i <= $count; ++$i) {
            $media = new Media();
            $media->setBinaryContent($faker->image());
            $media->setEnabled(true);
            $media->setName($faker->sentence(1));
            $media->setContext('default');
            $media->setProviderName('sonata.media.provider.image');
            $mediaManager->save($media, false);

            $article = new Articles();
            $article->setEnabled(true);
            $article->setName($faker->sentence(6));
            $article->setDescription($faker->sentence(random_int(30, 60)));
            $article->setBody($faker->sentence(random_int(300, 600)));
            $article->setPublicationAt($faker->dateTimeBetween('-30 days', '-1 days'));
            $article->setImage($media);

            $manager->persist($article);
        }

        $manager->flush();
    }

    /**
     * @return \Faker\Factory|\Faker\Generator|object
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }
}
