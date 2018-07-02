<?php

namespace CompoWebsiteDemo\Tests;

use CompoWebsiteDemo\AppBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
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
