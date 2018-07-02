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


use Compo\NewsBundle\Entity\News;
use Compo\NewsBundle\Entity\NewsTag;
use Compo\Sonata\MediaBundle\Entity\Media;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadPageData
 */
class LoadNewsData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 7;
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

        $tags = [];

        foreach ($faker->words(random_int(5, 10)) as $tag) {
            $newsTag = new NewsTag();

            $newsTag->setName($tag);
            $newsTag->setColor($faker->hexColor);
            $manager->persist($newsTag);

            $tags[] = $newsTag;
        }

        $manager->flush();


        for ($i = 1; $i <= $count; $i++) {
            $media = new Media();

            $media->setBinaryContent($faker->image());
            $media->setEnabled(true);
            $media->setName($faker->sentence(1));
            $media->setContext('default');
            $media->setProviderName('sonata.media.provider.image');
            $mediaManager->save($media, false);

            $news = new News();
            $news->setEnabled(true);
            $news->setViews(random_int(10, 100));
            $news->setName($faker->sentence(6));
            $news->setDescription($faker->text(random_int(300, 600)));

            $text = '';
            $count_p = random_int(4, 10);

            for ($p = 4; $p <= $count_p; $p++) {
                $text .= '<p>' . $faker->text(random_int(300, 600)) . '</p>';
            }

            $news->setBody($text);

            $news->setPublicationAt($faker->dateTimeBetween('-30 days', '-1 days'));
            $news->setImage($media);

            $tagsCount = random_int(0, 3);

            shuffle($tags);

            for ($t = 1; $t <= $tagsCount; $t++) {
                $news->addTag($tags[$t]);
            }

            $manager->persist($news);
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
