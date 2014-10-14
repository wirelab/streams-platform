<?php namespace Streams\Platform\Addon\Tag;

use Streams\Platform\Addon\AddonServiceProvider;

class TagServiceProvider extends AddonServiceProvider
{
    protected $type = 'tag';

    protected function onAfterRegister()
    {
        foreach ($this->app->make('streams.tag.loaded') as $abstract) {

            $tag = $this->app->make($abstract);

            $this->app->make('anomaly.lexicon')->registerPlugin($tag->getSlug(), $abstract);

        }
    }
}
