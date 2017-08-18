<?php

namespace BlazeCode\Laravel;

use BlazeCode\Contract\RequestInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Request as FacadeRequest;

/**
 * @license MIT
 * @copyright 2017-2018
 * @author Daison Cariño <daison12006013@gmail.com>
 */
class Request implements RequestInterface
{
    /**
     * Extract the raw to be a metadata.
     *
     * @param array\mixed $raw
     * @return array
     */
    private function processRawAsMetaData($raw) : array
    {
        if ($raw instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $data = $raw->toArray();

            unset($data['data']);

            return $data;
        }

        return $raw;
    }

    /**
     * {@inherit}
     */
    public function whenSuccess($transformed, $raw) : array
    {
        return [
            'success' => true,
            'code' => Response::HTTP_OK,
            'data' => $transformed,
            'metadata' => $this->processRawAsMetaData($raw),
            'processing_time' => microtime(true) - LARAVEL_START,
        ];
    }

    /**
     * {@inherit}
     */
    public function whenError($e) : array
    {
        $resp = [
            'success' => false,
            'code' => (method_exists($e, 'getCode') && $e->getCode() !== 0)
                ? $e->getCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ];

        # debug = false
        # env = production
        # return the response instead.
        if (config('app.debug') === false && config('app.env') === 'production') {
            return $resp;
        }

        # if 'local', 'dev', 'develop', 'development'
        # throw the exception itself
        if (
            config('app.debug') &&
            in_array(
                config('app.env'), [
                    'local',
                    'dev',
                    'develop',
                    'development'
            ])
        ) {
            throw $e;
        }

        # or else, add the trace
        $resp['trace'] = $e->getTrace();

        return $resp;
    }
}
