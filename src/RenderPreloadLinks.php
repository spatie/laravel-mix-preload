<?php

namespace Spatie\MixPreload;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class RenderPreloadLinks
{
    /** @var array */
    protected $manifest;

    /** @var string|null */
    protected $assetUrl;

    public static function create(string $manifestPath = null, string $assetUrl = null): RenderPreloadLinks
    {
        if (!$manifestPath) {
            $manifestPath = public_path('mix-manifest.json');
        }

        $manifest = json_decode(
            file_get_contents($manifestPath),
            true
        );

        return new self($manifest, $assetUrl);
    }

    public function __construct(array $manifest, string $assetUrl = null)
    {
        $this->manifest = $manifest;
        $this->assetUrl = $assetUrl;
    }

    public function __invoke(): HtmlString
    {
        return $this->getManifestEntries()
            ->mapSpread(function (string $path, string $name) {
                $rel = $this->getRelAttribute($name);

                if (!$rel) {
                    return null;
                }

                $as = $this->getAsAttribute($path);

                if (!$as) {
                    return null;
                }

                $path = $this->getHrefAttribute($path);

                return "<link rel=\"{$rel}\" href=\"{$path}\" as=\"{$as}\">";
            })
            ->filter()
            ->pipe(function (Collection $links) {
                return new HtmlString($links->implode("\n"));
            });
    }

    protected function getManifestEntries(): Collection
    {
        return collect($this->manifest)
            ->map(function (string $path, string $name) {
                return [$path, $name];
            })
            ->values();
    }

    protected function getRelAttribute(string $name): ?string
    {
        if (Str::contains($name, 'preload')) {
            return 'preload';
        }

        if (Str::contains($name, 'prefetch')) {
            return 'prefetch';
        }

        return null;
    }

    protected function getAsAttribute(string $path): ?string
    {
        if (Str::contains($path, '.js')) {
            return 'script';
        }

        if (Str::contains($path, '.css')) {
            return 'style';
        }
        
        if (Str::contains($path, ['.woff', '.woff2', '.ttf', '.eot', '.svg', '.ttc'])) {
            return 'font';
        }

        return null;
    }

    protected function getHrefAttribute(string $path): ?string
    {
        if ($this->assetUrl) {
            return $this->assetUrl . $path;
        }

        return $path;
    }
}
