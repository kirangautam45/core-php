<?php

class SupabaseStorage {
    private $url;
    private $key;
    private $bucket;

    public function __construct() {
        $this->url = $_ENV['SUPABASE_URL'] ?? getenv('SUPABASE_URL') ?? '';
        $this->key = $_ENV['SUPABASE_KEY'] ?? getenv('SUPABASE_KEY') ?? ''; // Service role or anon key with write access
        $this->bucket = 'avatars';
    }

    public function upload($file, $filename) {
        try {
            $ch = curl_init();
            $targetUrl = $this->url . '/storage/v1/object/' . $this->bucket . '/' . $filename;
            
            $fileHandle = fopen($file, 'r');
            $fileSize = filesize($file);
            $mimeType = mime_content_type($file);

            curl_setopt($ch, CURLOPT_URL, $targetUrl);
            curl_setopt($ch, CURLOPT_PUT, 1);
            curl_setopt($ch, CURLOPT_INFILE, $fileHandle);
            curl_setopt($ch, CURLOPT_INFILESIZE, $fileSize);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->key,
                'ApiKey: ' . $this->key,
                'Content-Type: ' . $mimeType,
                'x-upsert: true'
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            curl_close($ch);
            fclose($fileHandle);
            
            return $httpCode === 200;
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
