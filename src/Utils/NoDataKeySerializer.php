<?php

namespace BlazeCode\Utils;

use League\Fractal\Serializer\ArraySerializer;

/**
 * @license MIT
 * @copyright 2017-2018
 * @author Daison Cariño <daison12006013@gmail.com>
 */
class NoDataKeySerializer extends ArraySerializer
{
    /**
     * {@inheritdoc}
     */
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function item($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }
        return $data;
    }
}
