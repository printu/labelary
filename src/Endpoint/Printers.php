<?php

namespace Labelary\Endpoint;

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
     * @throws \GuzzleHttp\Exception\GuzzleException
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

        if (!isset($options['index'])) {
            $options['index'] = 0;
        }

        if (!isset($options['response'])) {
            $options['response'] = 'image/png';
        }

        if (!isset($options['zpl'])) {
            $this->mockException('ZPL label code is required!', 'POST');
        }

        $path = 'printers/'.$options['dpmm'].'/labels/'.$options['width'].'x'.$options['height'].'/'.$options['index'].'/';

        return $this->client->post($path, $options['zpl'], $options['response']);
    }
}
