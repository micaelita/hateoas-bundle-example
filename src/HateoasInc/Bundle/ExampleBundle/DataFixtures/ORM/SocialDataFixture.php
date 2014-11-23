<?php
/**
 * @copyright 2014 Integ S.A.
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author Javier Lorenzana <javier.lorenzana@gointegro.com>
 */

namespace HateoasInc\Bundle\ExampleBundle\DataFixtures\ORM;

// ORM.
use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager,
    Doctrine\Common\Collections\ArrayCollection;
// Entities.
use HateoasInc\Bundle\ExampleBundle\Entity;
// DI.
use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

class SocialDataFixture
    extends AbstractFixture
    implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = NULL)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $patternsGroup = new Entity\UserGroup;
        $patternsGroup->setName("Design Pattern Abusers Anonymous");
        $manager->persist($patternsGroup);
        $this->addReference('patterns-group', $patternsGroup);

        $coffeeGroup = new Entity\UserGroup;
        $coffeeGroup->setName("Public Coffee Lovers");
        $manager->persist($coffeeGroup);
        $this->addReference('coffee-group', $coffeeGroup);

        $user = new Entity\User;
        $user->setUsername("this_guy");
        $user->setEmail("this.guy@gmail.com");
        $user->setPassword("cl34rt3xt");
        $user->addUserGroup($patternsGroup);
        $manager->persist($user);

        $post = new Entity\Post;
        $post->setContent("Check this bundle out. #RockedMyWorld");
        $post->setOwner($user);
        $manager->persist($post);

        $comment = new Entity\Comment;
        $comment->setContent("Mine too. #RockedMyWorld");
        $comment->setOwner($user);
        $comment->setSubject($post);
        $manager->persist($comment);

        $manager->flush();
    }
}
