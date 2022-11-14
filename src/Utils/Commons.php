<?php
namespace App\Utils;

use Exception;
use Throwable;

/**
 * Class Commons.
 */
class Commons
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * Set date to real UTC.
     *
     * @param \DateTime $date
     * @param string $time
     *
     * @return bool|\DateTime
     */
    public static function getDateToUTC(\DateTime $date, $time = '00:00:01')
    {
        return \DateTime::createFromFormat('d/m/Y H:i:s', $date->format('d/m/Y').' '.$time, new \DateTimeZone('UTC'));
    }

    /**
     * Rewrite options.
     *
     * @param array $options
     * @param array $aOptions
     *
     * @return mixed
     */
    public static function rewriteOption($options, $aOptions)
    {
        if (!empty($options)) {
            foreach ($options as $key => $option) {
                if (is_array($option)) {
                    foreach ($option as $subKey => $subOption) {
                        $aOptions[$key][$subKey] = $subOption;
                    }
                } else {
                    $aOptions[$key] = $option;
                }
            }
        }

        return $aOptions;
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function generateUuid()
    {
        $data = random_bytes(16);

        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * @param Throwable $throwable
     * @return mixed
     */
    public static function log(Throwable $throwable)
    {
        $log = [
            'code' => $throwable->getCode(),
            'message' => $throwable->getMessage(),
            'called' => [
                'file' => $throwable->getTrace()[0]['file'],
                'line' => $throwable->getTrace()[0]['line'],
            ],
            'occurred' => [
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine(),
            ],
        ];

        if ($throwable->getPrevious() instanceof Exception) {
            $log += [
                'previous' => [
                    'message' => $throwable->getPrevious()->getMessage(),
                    'exception' => get_class($throwable->getPrevious()),
                    'file' => $throwable->getPrevious()->getFile(),
                    'line' => $throwable->getPrevious()->getLine(),
                ],
            ];
        }
        return json_encode($log);
    }

    /**
     * Return the given string slugified
     * @param $string
     * @return string|string[]|null
     */
    public static function slugify($string)
    {
        $rule = 'NFD; [:Nonspacing Mark:] Remove; NFC';
        $transliterator = \Transliterator::create($rule);
        $string = $transliterator->transliterate($string);

        return preg_replace(
            '/[^a-z0-9]/',
            '-',
            strtolower(trim(strip_tags($string)))
        );
    }

    /**
     * Return the given string slugified
     * @param $string
     * @return string|string[]|null
     */
    public static function slugifyFile($string)
    {
        $rule = 'NFD; [:Nonspacing Mark:] Remove; NFC';
        $transliterator = \Transliterator::create($rule);
        $string = $transliterator->transliterate($string);

        return preg_replace(
            '/[^a-z0-9\.]/',
            '-',
            strtolower(trim(strip_tags($string)))
        );
    }
}
