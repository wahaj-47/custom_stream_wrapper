<?php

namespace Drupal\custom_stream_wrapper\StreamWrapper;

use Drupal\Core\StreamWrapper\LocalReadOnlyStream;
use Drupal\Core\StreamWrapper\StreamWrapperInterface;

/**
 * Abstract stream wrapper class for symlinked files. 
 */
abstract class SymlinkStream extends LocalReadOnlyStream
{
    /**
     * {@inheritdoc}
     */
    protected function getLocalPath($uri = NULL)
    {
        if (!isset($uri)) {
            $uri = $this->uri;
        }
        $path = $this->getDirectoryPath() . '/' . $this->getTarget($uri);


        // In PHPUnit tests, the base path for local streams may be a virtual
        // filesystem stream wrapper URI, in which case this local stream acts like
        // a proxy. realpath() is not supported by vfsStream, because a virtual
        // file system does not have a real filepath.
        if (str_starts_with($path, 'vfs://')) {
            return $path;
        }

        $realpath = realpath($path);
        if (!$realpath) {
            // This file does not yet exist.
            $realpath = realpath(dirname($path)) . '/' . \Drupal::service('file_system')->basename($path);
        }

        $directory = realpath($this->getDirectoryPath());
        if (
            !$realpath ||
            !$directory
            // Overriden to not compare the $realpath and $directory because they will always be different for symlinked files. Perhaps there is a better way to do this 
            // !str_starts_with($realpath, $directory) 
        ) {
            return FALSE;
        }

        return $realpath;
    }
}
