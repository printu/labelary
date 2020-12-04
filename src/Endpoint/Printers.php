<?php

namespace Labelary\Endpoint;

use GuzzleHttp\Exception\GuzzleException;

class Printers extends Base
{
    const ENUM_DPMM_6 = '6dpmm';
    const ENUM_DPMM_8 = '8dpmm';
    const ENUM_DPMM_12 = '12dpmm';
    const ENUM_DPMM_24 = '24dpmm';

    /**
     * Get label
     * @see http://labelary.com/service.html#parameters
     * @param array $options
     * @return mixed
     * @throws GuzzleException
     */
    public function labels(array $options)
    {
        if (!isset($options['dpmm'])) {
            $options['dpmm'] = self::ENUM_DPMM_8;
        }

        if (!isset($options['width'])) {
            $options['width'] = 4;
        }

        if (!isset($options['height'])) {
            $options['height'] = 6;
        }

        if (!isset($options['response'])) {
            $options['response'] = 'image/png';
        }

        if (!isset($options['index']) && $options['response'] !== 'application/pdf') {
            $options['index'] = 0;
        }

        if (!isset($options['zpl'])) {
            $this->mockException('ZPL label code is required!', 'POST');
        }

        $headers = [
            'Accept' => $options['response'],
        ];
        if (isset($options['rotate'])) {
            $headers['X-Rotation'] = (int)$options['rotate'];
        }

        $path = 'printers/'.$options['dpmm'].'/labels/'.$options['width'].'x'.$options['height'].'/';
        if (isset($options['index']) && (int)$options['index'] >= 0) {
            $path .= $options['index'].'/';
        }

        return $this->client->post($path, $options['zpl'], $headers);
    }
}
