<?php

namespace Support\Filesystem;

use Phalcon\Exception;
use Phalcon\Mvc\User\Component;
use Aws\S3\S3Client;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter as S3Adapter;
use Support\Filesystem\Contracts\Filesystem;
use Support\Filesystem\FilesystemS3Adapter;

class FilesystemManager extends Component
{
    /**
     * The list of resolved filesystem drivers
     *
     * @var array
     */
    protected $disks = [];

    /**
     * Get a particular filesystem
     *
     * @param string $name
     * @return \Support\Filesystem\Contracts\Filesystem
     */
    public function disk(string $name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->disks[$name] = $this->get($name);
    }

    /**
     * Get or resolve the new filesystem
     *
     * @param string $name
     * @return \Support\Filesystem\Contracts\Filesystem
     */
    public function get(string $name)
    {
        return $this->disks[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the filesystem from the given name
     *
     * @param string $name
     * @return \Support\Filesystem\Contracts\Filesystem
     */
    protected function resolve(string $name)
    {
        $config = config('filesystems.disks.' . $name);;
        $config = $config ? $config->toArray() : [];

        if (! isset($config['driver'])) {
            throw new Exception(sprintf('The disk configuration for [%s] is not defined.', $name));
        }

        $driverMethod = 'create'.ucfirst($config['driver']).'Driver';

        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config);
        } else {
            throw new Exception(sprintf('Driver [%s] is not supported.', $config['driver']));
        }
    }

    /**
     * Create an instance of the Amazon S3 driver
     *
     * @param array $config
     * @return \Support\Filesystem\FilesystemS3Adapter
     */
    public function createS3Driver(array $config)
    {
        $s3Config = $this->formatS3Config($config);

        $root = $s3Config['root'] ?? null;

        $options = $config['options'] ?? [];

        return new FilesystemS3Adapter(new Flysystem(new S3Adapter(
            new S3Client($s3Config), $s3Config['bucket'], $root, $options), $config
        ));
    }

    /**
     * Format the given S3 configuration with the default options.
     *
     * @param  array  $config
     * @return array
     */
    protected function formatS3Config(array $config)
    {
        $config += ['version' => 'latest'];

        if ($config['key'] && $config['secret']) {
            $config['credentials'] = [
                'key' => $config['key'],
                'secret' => $config['secret']
            ];
        }

        return $config;
    }

    /**
     * Get the default driver name
     *
     * @return string
     */
    protected function getDefaultDriver()
    {
        return config('filesystems.default');
    }
}
