<?php
include("config.php");

class ImageDownloader {

    public function download(string $imageURL, string $savedFileName) {
        $ch = curl_init($imageURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $raw = curl_exec($ch);
        curl_close($ch);
        if (file_exists($savedFileName)) {
            unlink($savedFileName);
        }
        $fp = fopen($savedFileName, "wb");
        fwrite($fp, $raw);
        fclose($fp);
    }

}