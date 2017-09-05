<?php

namespace BlazeCode;

use Closure;
use Throwable;

/**
 * @license MIT
 * @copyright 2017-2018
 * @author Daison Cariño <daison12006013@gmail.com>
 */
class RequestHandler
{
    /**
     * @var \BlazeCode\Contract\RequestInterface $receipt
     */
    private $receipt;

    /**
     * Constructor.
     *
     * @param \BlazeCode\Contract\RequestInterface $receipt
     */
    public function __construct(Contract\RequestInterface $receipt)
    {
        $this->receipt = $receipt;
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
     * @param array $callback
     * @param array|mixed $raw
     * @return array
     */
    private function transformRaw($callback, $raw) : array
    {
        $fractal = new \League\Fractal\Manager;
        $fractal->setSerializer(new Utils\NoDataKeySerializer());

        if (isset($callback['fractal']['manager'])) {
            call_user_func_array($callback['fractal']['manager'], [$fractal]);
        }

        $explode = explode('::', $callback['fractal']['transformer']);

        $type_class = (count($explode) === 2) ? $explode[0] : 'Item';
        $transformer_class = (count($explode) === 2) ? $explode[1] : $explode[0];

        $reflection = new \ReflectionClass("League\Fractal\Resource\\$type_class");
        $resource = $reflection->newInstanceArgs([$raw, new $transformer_class]);

        $transformed = $fractal->createData($resource)->toArray();

        return $transformed;
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
            $raw = call_user_func($callback['requests']['before']);
            $trans = $raw;

            if (isset($callback['fractal']['transformer']) && $callback['fractal']['transformer']) {
                $trans = $this->transformRaw($callback, $raw);
            }

            $data = $this->receipt->whenSuccess($trans, $raw);
        } catch (Throwable $e) {
            $data = $this->receipt->whenError($e);
        }

        return $this->callAfter(
            $data,
            $callback['requests']['after']
        );
    }
}
