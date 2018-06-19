<?php

namespace CompoWebsiteDemo\Tests;

use PHPUnit\Framework\TestCase;
use CompoWebsiteDemo\AppBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testOptions()
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[

        ]]);

        $this->assertSame('CompoWebsiteDemo', $config['title']);
    }
}
