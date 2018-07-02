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

use Compo\Sonata\PageBundle\Entity\Page;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sonata\PageBundle\Model\PageBlockInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadPageData
 */
class LoadPageData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 15;
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
        $this->createHomePage();

        $this->createHomePageWellcomeBlock();
        $this->createHomePageGitHubBlock();
        $this->createHomePageDocumentationBlock();
        $this->createHomePageAdminBlock();

        $this->createHomePageCoreBundleBlock();
        $this->createHomePageSonataBundleBlock();

        $this->createHomePageAdvantagesBundleBlock();
        $this->createHomePageArticlesBundleBlock();
        $this->createHomePageBannerBundleBlock();
        $this->createHomePageContactsBundleBlock();
        $this->createHomePageFaqBundleBlock();
        $this->createHomePageFeedbackBundleBlock();
        $this->createHomePageImportBundleBlock();

        $this->createHomePageMenuBundleBlock();
        $this->createHomePageNewsBundleBlock();
        $this->createHomePageNotificationBundleBlock();
        $this->createHomePagePageCodeBundleBlock();
        $this->createHomePageRedirectBundleBlock();
        $this->createHomePageSeoBundleBlock();
        $this->createHomePageSocialBundleBlock();
    }

    /**
     *
     */
    public function createHomePage()
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();

        /** @var Page $page */
        $page = $pageManager->find(1);

        /** @var PageBlockInterface $content */
        $content = $blockInteractor->createNewContainer([
            'enabled' => true,
            'page' => $page,
            'code' => 'content',
        ]);

        $page->addBlocks($content);

        $content->setName('The container content container');

        $blockManager->save($content);

        $pageManager->save($page);
    }

    /**
     * @return \Sonata\PageBundle\Model\PageManagerInterface
     */
    public function getPageManager()
    {
        return $this->container->get('sonata.page.manager.page');
    }

    /**
     * @return \Sonata\BlockBundle\Model\BlockManagerInterface
     */
    public function getBlockManager()
    {
        return $this->container->get('sonata.page.manager.block');
    }

    /**
     * @return \Sonata\PageBundle\Entity\BlockInteractor
     */
    public function getBlockInteractor()
    {
        return $this->container->get('sonata.page.block_interactor');
    }

    /**
     *
     */
    public function createHomePageWellcomeBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('Wellcome',
            <<<CONTENT
<h1>Wellcome to WebSiteDemo!</h1>
<div class="well">
This a demo site.
</div>
CONTENT
        );

        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);
        $formatterBlock->setPage($page);
        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     * @param $name
     * @param $content
     * @return \Compo\Sonata\PageBundle\Entity\Block
     */
    public function createFormatterBlock($name, $content)
    {
        $blockManager = $this->getBlockManager();
        /** @var \Compo\Sonata\PageBundle\Entity\Block $text */
        $text = $blockManager->create();

        $text->setName($name);
        $text->setType('sonata.formatter.block.formatter');

        $text->setSetting('content', $content);
        $text->setSetting('rawContent', $content);

        $text->setSetting('format', 'richhtml');
        $text->setSetting('template', '@SonataFormatter/Block/block_formatter.html.twig');

        $text->setEnabled(true);

        return $text;
    }

    /**
     *
     */
    public function createHomePageGitHubBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('GitHub',
            <<<CONTENT
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">GitHub</h3>
    </div>
    <div class="panel-body">
        <ul>
            <li><a href="https://github.com/comporu/compo-website-demo">https://github.com/comporu/compo-website-demo</a></li>
            <li><a href="https://github.com/comporu/compo-core">https://github.com/comporu/compo-core</a></li>
        </ul>
        
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageDocumentationBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('Documentation',
            <<<CONTENT
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Documentation</h3>
    </div>
    <div class="panel-body">
        <a href="http://docs.compo-symfony-cms.ru/">http://docs.compo-symfony-cms.ru/</a>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageAdminBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('Admin',
            <<<CONTENT
<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Admin</h3>
    </div>
    <div class="panel-body">
        <p>
            <b>Admin area</b>: <a href="/admin">/admin</a>
        </p>
         <p>
            <b>Login/password</b>: admin
        </p>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageCoreBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('CoreBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">CoreBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Settings</h4>
                
        <h4>Blocks</h4>
        <ul>
            <li>AdminCustomStats</li>
            <li>AdminStats</li>
            <li>DateStatsAdmin</li>
            <li>Error404</li>
            <li>TextPage</li>
            <li>Panel</li>
            <li>ShowMore</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageSonataBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('SonataBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">SonataBundle</h3>
    </div>
    <div class="panel-body">
        SonataBundle
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageAdvantagesBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('AdvantagesBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">AdvantagesBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Blocks</h4>
        <ul>
            <li>Advantages</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);


        $blockManager = $this->getBlockManager();

        /** @var PageBlockInterface $advantages */
        $advantages = $blockManager->create();

        $advantages->setName('Advantages');
        $advantages->setType('compo_advantages.block.service.advantages');
        $advantages->setSetting('id', 1);
        $advantages->setEnabled(true);
        $advantages->setPage($page);
        $advantages->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($advantages);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageArticlesBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('ArticlesBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">ArticlesBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Blocks</h4>
        <ul>
            <li>ArticlesLast</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);


        $blockManager = $this->getBlockManager();

        /** @var PageBlockInterface $lastArticles */
        $lastArticles = $blockManager->create();

        $lastArticles->setName('Last Articles');
        $lastArticles->setType('compo_articles.block.service.articles_last');
        $lastArticles->setEnabled(true);
        $lastArticles->setPage($page);
        $lastArticles->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($lastArticles);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageBannerBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('BannerBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">BannerBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Blocks</h4>
        <ul>
            <li>Banner</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);


        $blockManager = $this->getBlockManager();

        /** @var PageBlockInterface $banner */
        $banner = $blockManager->create();

        $banner->setName('Banner');
        $banner->setType('compo_banner.block.service.banner');
        $banner->setSetting('id', 1);
        $banner->setEnabled(true);
        $banner->setPage($page);
        $banner->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($banner);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageContactsBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('ContactsBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">ContactsBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Blocks</h4>
        <ul>
            <li>ContactsMain</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);


        $blockManager = $this->getBlockManager();

        /** @var PageBlockInterface $contacts */
        $contacts = $blockManager->create();

        $contacts->setName('Contacts');
        $contacts->setType('compo_contacts.block.service.contacts_main');
        $contacts->setEnabled(true);
        $contacts->setPage($page);
        $contacts->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($contacts);


        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageFaqBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('FaqBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">FaqBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Blocks</h4>
        <ul>
            <li>FaqLast</li>
        </ul>
        
        <h4>Settings</h4>
        <ul>
            <li>PerPage</li>
        </ul>
        
        <h4>Pages</h4>
        <ul>
            <li>Index</li>
            <li>Show</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);


        $blockManager = $this->getBlockManager();

        /** @var PageBlockInterface $lastFaq */
        $lastFaq = $blockManager->create();

        $lastFaq->setName('Last Faq');
        $lastFaq->setType('compo_faq.block.service.faq_last');
        $lastFaq->setEnabled(true);
        $lastFaq->setPage($page);
        $lastFaq->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($lastFaq);


        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageFeedbackBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('FeedbackBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">FeedbackBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Blocks</h4>
        <ul>
            <li>FeedbackForm</li>
        </ul>
        
        <h4>Forms</h4>
        <ul>
            <li>Callback</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);


        $blockManager = $this->getBlockManager();

        /** @var PageBlockInterface $feedback */
        $feedback = $blockManager->create();

        $feedback->setName('Feedback');
        $feedback->setType('compo_feedback.block.service.feedback_form');
        $feedback->setSetting('type', 'compo_feedback.feedback');
        $feedback->setEnabled(true);
        $feedback->setPage($page);
        $feedback->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($feedback);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageImportBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('ImportBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">ImportBundle</h3>
    </div>
    <div class="panel-body">
        ImportBundle
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageMenuBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('MenuBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">MenuBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Blocks</h4>
        <ul>
            <li>Menu</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageNewsBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('NewsBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">NewsBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Blocks</h4>
        <ul>
            <li>NewsLast</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);


        $blockManager = $this->getBlockManager();

        /** @var PageBlockInterface $lastNews */
        $lastNews = $blockManager->create();

        $lastNews->setName('Last News');
        $lastNews->setType('compo_news.block.service.news_last');
        $lastNews->setEnabled(true);
        $lastNews->setPage($page);
        $lastNews->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($lastNews);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageNotificationBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('NotificationBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">NotificationBundle</h3>
    </div>
    <div class="panel-body">
        NotificationBundle
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePagePageCodeBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('PageCode',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">PageCode</h3>
    </div>
    <div class="panel-body">
        PageCode
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageRedirectBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('RedirectBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">RedirectBundle</h3>
    </div>
    <div class="panel-body">
        RedirectBundle
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageSeoBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('SeoBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">SeoBundle</h3>
    </div>
    <div class="panel-body">
        SeoBundle
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);

        $pageManager->save($page);
    }

    /**
     *
     */
    public function createHomePageSocialBundleBlock()
    {
        $pageManager = $this->getPageManager();

        /** @var Page $page */
        $page = $pageManager->find(1);

        $containerBlock = $page->getContainerByCode('content');

        $formatterBlock = $this->createFormatterBlock('SocialBundle',
            <<<CONTENT
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">SocialBundle</h3>
    </div>
    <div class="panel-body">
        <h4>Blocks</h4>
        <ul>
            <li>SocialBlock</li>
        </ul>
    </div>
</div>
CONTENT
        );

        $formatterBlock->setPage($page);
        $formatterBlock->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($formatterBlock);


        $blockManager = $this->getBlockManager();

        /** @var PageBlockInterface $social */
        $social = $blockManager->create();

        $social->setName('Social');
        $social->setType('compo_social.block.service.social');
        $social->setEnabled(true);
        $social->setPage($page);
        $social->setPosition(\count($containerBlock->getChildren()) + 1);

        $containerBlock->addChildren($social);


        $pageManager->save($page);
    }

    /**
     * @return \Sonata\PageBundle\Model\SiteManagerInterface
     */
    public function getSiteManager()
    {
        return $this->container->get('sonata.page.manager.site');
    }

    /**
     * @return \Faker\Factory|\Faker\Generator|object
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }
}
