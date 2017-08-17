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
        if (config('app.debug')) {
            throw $e;
        }

        return [
            'success' => false,
            'code' => method_exists($e, 'getCode') ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ];
    }
}
