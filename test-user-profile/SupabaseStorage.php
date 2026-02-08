<?php
require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

class SupabaseStorage {
    private $client;
    private $url;
    private $key;
    private $bucket;

    public function __construct() {
        $this->url = $_ENV['SUPABASE_URL'];
        $this->key = $_ENV['SUPABASE_KEY']; // Service role or anon key with write access
        $this->bucket = 'avatars';
        
        $this->client = new Client([
            'base_uri' => $this->url . '/storage/v1/object/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->key,
                'ApiKey' => $this->key,
            ]
        ]);
    }

    public function upload($file, $filename) {
        try {
            $response = $this->client->request('POST', $this->bucket . '/' . $filename, [
                'body' => fopen($file, 'r'),
                'headers' => [
                    'Content-Type' => mime_content_type($file),
                    'x-upsert' => 'true' // Overwrite if exists
                ]
            ]);
            
            return $response->getStatusCode() === 200;
        } catch (Exception $e) {
            error_log("Upload failed: " . $e->getMessage());
            return false;
        }
    }

    public function getUrl($filename) {
        if (empty($filename)) return null;
        return $this->url . '/storage/v1/object/public/' . $this->bucket . '/' . $filename;
    }
}
