<?php

namespace Spatie\MixPreload\Tests;

use PHPUnit\Framework\TestCase;
use Spatie\MixPreload\RenderPreloadLinks;

class RenderPreloadLinksTest extends TestCase
{
    /** @var string */
    protected $links;

    public function setUp(): void
    {
        $this->links = (new RenderPreloadLinks([
            '/js/app.js' => '/js/app.js',
            '/js/preload-something.js' => '/js/preload-something.js',
            '/js/vendors~preload-something.js' => '/js/vendors~preload-something.js',
            '/js/prefetch-something.js' => '/js/prefetch-something.js',
            '/js/vendors~prefetch-something.js' => '/js/vendors~prefetch-something.js',
            '/css/app.css' => '/css/app.css',
            '/css/preload-something.css' => '/css/preload-something.css',
            '/css/prefetch-something.css' => '/css/prefetch-something.css',
        ]))();
    }

    /** @test */
    public function it_generates_preload_script_links()
    {
        $this->assertStringContainsString(
            '<link rel="preload" href="/js/preload-something.js" as="script">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="preload" href="/js/vendors~preload-something.js" as="script">',
            $this->links
        );
    }

    /** @test */
    public function it_generates_prefetch_script_links()
    {
        $this->assertStringContainsString(
            '<link rel="prefetch" href="/js/prefetch-something.js" as="script">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="prefetch" href="/js/vendors~prefetch-something.js" as="script">',
            $this->links
        );
    }

    /** @test */
    public function it_generates_preload_style_links()
    {
        $this->assertStringContainsString(
            '<link rel="preload" href="/css/preload-something.css" as="style">',
            $this->links
        );
    }

    /** @test */
    public function it_generates_prefetch_style_links()
    {
        $this->assertStringContainsString(
            '<link rel="prefetch" href="/css/prefetch-something.css" as="style">',
            $this->links
        );
    }

    /** @test */
    public function it_doesnt_generate_unnecessary_preload_or_prefetch_links()
    {
        $this->assertStringNotContainsString(
            '<link rel="preload" href="/js/app.js" as="script">',
            $this->links
        );

        $this->assertStringNotContainsString(
            '<link rel="prefetch" href="/js/app.js" as="script">',
            $this->links
        );
    }
}
