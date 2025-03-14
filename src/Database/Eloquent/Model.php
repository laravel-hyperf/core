<?php

declare(strict_types=1);

namespace LaravelHyperf\Database\Eloquent;

use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\Stringable\Str;
use LaravelHyperf\Broadcasting\Contracts\HasBroadcastChannel;
use LaravelHyperf\Database\Eloquent\Concerns\HasCallbacks;
use LaravelHyperf\Database\Eloquent\Concerns\HasObservers;
use LaravelHyperf\Database\Eloquent\Concerns\HasRelations;
use LaravelHyperf\Router\Contracts\UrlRoutable;

abstract class Model extends BaseModel implements UrlRoutable, HasBroadcastChannel
{
    use HasCallbacks;
    use HasRelations;
    use HasObservers;

    protected ?string $connection = null;

    public function resolveRouteBinding($value)
    {
        /* @phpstan-ignore-next-line */
        return $this->where($this->getRouteKeyName(), $value)->firstOrFail();
    }

    /**
     * Create a new Model Collection instance.
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }

    /**
     * Get the broadcast channel route definition that is associated with the given entity.
     */
    public function broadcastChannelRoute(): string
    {
        return str_replace('\\', '.', get_class($this)) . '.{' . Str::camel(class_basename($this)) . '}';
    }

    /**
     * Get the broadcast channel name that is associated with the given entity.
     */
    public function broadcastChannel(): string
    {
        return str_replace('\\', '.', get_class($this)) . '.' . $this->getKey();
    }
}
