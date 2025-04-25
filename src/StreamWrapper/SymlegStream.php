<?php

namespace Drupal\custom_stream_wrapper\StreamWrapper;

use Drupal\Component\Utility\UrlHelper;

/**
 * Defines a Drupal legacy public (symleg://) stream wrapper class.
 */
class SymlegStream extends SymlinkStream
{

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return t('Symleg stream');
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return t('Local files symlinked to legacy public directory.');
    }

    /**
     * {@inheritdoc}
     */
    public function getExternalUrl()
    {
        $path = str_replace('\\', '/', $this->getTarget());
        return static::baseUrl() . '/' . UrlHelper::encodePath($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectoryPath()
    {
        return static::basePath();
    }

    /**
     * Finds and returns the base URL for legacy://.
     */
    public static function baseUrl()
    {
        return $GLOBALS['base_url'] . '/' . static::basePath();
    }

    /**
     *  Returns the base path for legacy://.
     */
    public static function basePath()
    {
        return 'sites/all/files';
    }
}
