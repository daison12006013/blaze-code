<?php

namespace BlazeCode;

/**
 * @license MIT
 * @copyright 2017-2018
 * @author Daison Cariño <daison12006013@gmail.com>
 */
class RouteFactory
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Parse the data.
     *
     * @param array $data
     * @return array
     */
    public function parse($data = []) : array
    {
        if ($data) {
            $this->data = $data;
        }

        if (empty($this->data)) {
            throw new \RuntimeException('Empty route settings.');
        }

        $records = [];

        foreach ($this->data as $datum) {
            foreach ($datum['prefix'] as $prefix) {
                foreach ($datum['routes'] as $route) {
                    $must_prefix = false;

                    if (isset($datum['must_prefix']) && $datum['must_prefix'] === true) {
                        $must_prefix = true;
                    }

                    $records[] = [
                        'prefix' => $prefix,
                        'with_suffix' => (isset($datum['with_suffix']) && $datum['with_suffix']) ? true : false,
                        'namespace' => isset($datum['namespace']) ? $datum['namespace'] : null,
                        'middleware' => isset($datum['middleware']) ? $datum['middleware'] : [],
                        'route' => $route,
                    ];
                }
            }
        }

        return $records;
    }

    /**
     * A way to call the register.
     *
     * @param \BlazeCode\Contract\RouterInterface $instance
     * @param string $directory
     * @return void
     */
    public function register(Contract\RouterInterface $instance, $directory)
    {
        # it is like running it this way:
        # $instance->register($directory, $maps);
        return call_user_func_array(
            [$instance, 'register'],
            [$directory, $this->parse()]
        );
    }
}
