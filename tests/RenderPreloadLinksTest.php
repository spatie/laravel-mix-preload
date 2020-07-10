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

            '/fonts/font.woff' => '/fonts/font.woff',
            '/fonts/preload-font.woff' => '/fonts/preload-font.woff',
            '/fonts/preload-font.woff2' => '/fonts/preload-font.woff2',
            '/fonts/preload-font.ttf' => '/fonts/preload-font.ttf',
            '/fonts/preload-font.eot' => '/fonts/preload-font.eot',
            '/fonts/preload-font.svg' => '/fonts/preload-font.svg',
            '/fonts/preload-font.ttc' => '/fonts/preload-font.ttc',

            '/fonts/prefetch-font.woff' => '/fonts/prefetch-font.woff',
            '/fonts/prefetch-font.woff2' => '/fonts/prefetch-font.woff2',
            '/fonts/prefetch-font.ttf' => '/fonts/prefetch-font.ttf',
            '/fonts/prefetch-font.eot' => '/fonts/prefetch-font.eot',
            '/fonts/prefetch-font.svg' => '/fonts/prefetch-font.svg',
            '/fonts/prefetch-font.ttc' => '/fonts/prefetch-font.ttc',
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
    public function it_generates_preload_font_links()
    {
        $this->assertStringContainsString(
            '<link rel="preload" href="/fonts/preload-font.woff" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="preload" href="/fonts/preload-font.woff2" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="preload" href="/fonts/preload-font.ttf" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="preload" href="/fonts/preload-font.eot" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="preload" href="/fonts/preload-font.svg" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="preload" href="/fonts/preload-font.ttc" as="font">',
            $this->links
        );
    }

    /** @test */
    public function it_generates_prefetch_font_links()
    {
        $this->assertStringContainsString(
            '<link rel="prefetch" href="/fonts/prefetch-font.woff" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="prefetch" href="/fonts/prefetch-font.woff2" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="prefetch" href="/fonts/prefetch-font.ttf" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="prefetch" href="/fonts/prefetch-font.eot" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="prefetch" href="/fonts/prefetch-font.svg" as="font">',
            $this->links
        );

        $this->assertStringContainsString(
            '<link rel="prefetch" href="/fonts/prefetch-font.ttc" as="font">',
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

        $this->assertStringNotContainsString(
            '<link rel="preload" href="/fonts/font.woff" as="font">',
            $this->links
        );

        $this->assertStringNotContainsString(
            '<link rel="prefetch" href="/fonts/font.woff" as="font">',
            $this->links
        );
    }

    /** @test */
    public function an_asset_url_can_be_specified()
    {
        $links = (new RenderPreloadLinks([
            '/js/preload-app.js' => '/js/preload-app.js',
            '/js/prefetch-app.js' => '/js/prefetch-app.js',
        ], 'https://cdn.spatie.be'))();

        $this->assertStringContainsString(
            '<link rel="preload" href="https://cdn.spatie.be/js/preload-app.js" as="script">',
            $links
        );

        $this->assertStringContainsString(
            '<link rel="prefetch" href="https://cdn.spatie.be/js/prefetch-app.js" as="script">',
            $links
        );
    }
}
