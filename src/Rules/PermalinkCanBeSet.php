<?php

namespace Latus\BasePlugin\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Latus\Permalink\Models\Permalink;
use Latus\Permalink\Models\Traits\HasPermalinks;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PermalinkCanBeSet implements Rule
{
    public function __construct(
        public mixed $modelWithPermalink = null
    )
    {
        if ($this->modelWithPermalink && !in_array(HasPermalinks::class, class_uses_recursive(get_class($this->modelWithPermalink)))) {
            throw new \RuntimeException('Class "' . get_class($this->modelWithPermalink) . '" must use trait "' . HasPermalinks::class . '"');
        }
    }

    protected function isBlockedByRoute(string $permalink): bool
    {
        $routes = Route::getRoutes();
        $request = Request::create($permalink);

        try {
            $routes->match($request);

            return false;
        } catch (NotFoundHttpException $e) {
            return true;
        }
    }

    protected function isBlockedByPermalink(string $permalink): bool
    {
        return ($persistedModel = Permalink::where('url', $permalink)->first()) && ($this->modelWithPermalink && $relatedModel = $persistedModel->relatedModel()) && !$relatedModel->is($this->modelWithPermalink);
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        return $this->isBlockedByRoute($value) || $this->isBlockedByPermalink($value);
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'validation.permalink_blocked';
    }
}