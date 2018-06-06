<?php

namespace App\Storage\S3;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;

class s3 {

    protected $s3Client;

    public function __construct($key, $secret)
    {
        $awsCredentials = new Credentials($key, $secret);
        $this->s3Client = new S3Client([
            'version'     => 'latest',
            'region'      => 'eu-central-1',
            'credentials' => $awsCredentials
        ]);
    }

    public function getAllMods() {
        $result = [];
        try {
            $objects = $this->s3Client->getIterator('ListObjects', [
                'Bucket' => 'arm-storage-1',
                'Prefix' => 'mods/'
            ]);
            
            echo "Keys retrieved!" . PHP_EOL;
            foreach ($objects as $object) {
                if (strpos($object['Key'], '.zip') || strpos($object['Key'], '.ZIP') !== false) {
                    $result[] = $object['Key'];
                }
            }
        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        return $result;
    }
}