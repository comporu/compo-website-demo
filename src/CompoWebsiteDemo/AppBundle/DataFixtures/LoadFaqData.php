<?php

/*
 * This file is part of the CompoSymfonyCms package.
 * (c) Compo.ru <info@compo.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CompoWebsiteDemo\AppBundle\DataFixtures;

use Compo\FaqBundle\Entity\Faq;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadPageData.
 */
class LoadFaqData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
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

        $count = random_int(30, 60);

        for ($i = 1; $i <= $count; ++$i) {
            $faq = new Faq();
            $faq->setEnabled(true);
            $faq->setEmail($faker->safeEmail);
            $faq->setUsername($faker->firstNameMale);
            $faq->setName($faker->sentence(random_int(5, 10)));
            $faq->setAnswer($faker->sentence(random_int(100, 300)));
            $faq->setDescription($faker->sentence(random_int(30, 60)));
            $faq->setPublicationAt($faker->dateTimeBetween('-30 days', '-1 days'));
            $faq->setViews(random_int(100, 300));

            $manager->persist($faq);
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
