<?php

namespace Spatie\MixPreload;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class RenderPreloadLinks
{
    /** @var array */
    protected $manifest;

    public static function create(string $manifestPath = null): RenderPreloadLinks
    {
        if (! $manifestPath) {
            $manifestPath = public_path('mix-manifest.json');
        }

        $manifest = json_decode(
            file_get_contents($manifestPath),
            true
        );

        return new self($manifest);
    }

    public function __construct(array $manifest)
    {
        $this->manifest = $manifest;
    }

    public function __invoke(): HtmlString
    {
        return $this->getManifestEntries()
            ->mapSpread(function (string $path, string $name) {
                $rel = $this->getRelAttribute($name);

                if (! $rel) {
                    return null;
                }

                $as = $this->getAsAttribute($path);

                if (! $as) {
                    return null;
                }

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
}
