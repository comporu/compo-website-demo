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


use Compo\ContactsBundle\Entity\Contacts;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadPageData
 */
class LoadContactsData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
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

        $contacts = new Contacts();

        $contacts->setName('Main');
        $contacts->setPhone($faker->phoneNumber);
        $contacts->setEmail($faker->safeEmail);
        $contacts->setWorktime('10:00 - 19:00');
        $contacts->setAddress($faker->address);
        $contacts->setBankProps($faker->creditCardType . ': ' . $faker->creditCardNumber);
        $contacts->setCix(55.84325207);
        $contacts->setCiy(37.48890304);

        $manager->persist($contacts);
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
