<?php

namespace BlazeCode;

use Closure;
use Exception;

/**
 * @license MIT
 * @copyright 2017-2018
 * @author Daison Cariño <daison12006013@gmail.com>
 */
class RequestHandler
{
    /**
     * @var \BlazeCode\Contract\RequestInterface $recipe
     */
    private $recipe;

    /**
     * Constructor.
     *
     * @param \BlazeCode\Contract\RequestInterface $recipe
     */
    public function __construct(Contract\RequestInterface $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * Call the 'after' closure.
     *
     * @return mixed
     */
    private function callAfter($data, $closure)
    {
        return call_user_func_array($closure, [$data]);
    }

    /**
     * Transform a raw data.
     *
     * @param string $transformer
     * @param array|mixed $raw
     * @return array
     */
    private function transformRaw($transformer, $raw) : array
    {
        $fractal = new \League\Fractal\Manager;

        $explode = explode('::', $transformer);

        $type_class = (count($explode) === 2) ? $explode[0] : 'Item';
        $transformer_class = (count($explode) === 2) ? $explode[1] : $explode[0];

        $reflection = new \ReflectionClass("League\Fractal\Resource\\$type_class");
        $resource = $reflection->newInstanceArgs([$raw, new $transformer_class]);

        $transformed = $fractal->createData($resource)->toArray();

        return reset($transformed);
    }

    /**
     * Handle the request.
     *
     * @param Closure $callback
     * @return mixed
     */
    public function handle(array $callback)
    {
        try {
            $raw = call_user_func($callback['before']);
            $trans = $raw;

            if (isset($callback['transformer']) && $callback['transformer']) {
                $trans = $this->transformRaw($callback['transformer'], $raw);
            }

            $data = $this->recipe->whenSuccess($trans, $raw);
        } catch (Exception $e) {
            $data = $this->recipe->whenError($e);
        }

        return $this->callAfter(
            $data,
            $callback['after']
        );
    }
}
