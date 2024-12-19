<?php

namespace App\Service;


class UploadDocument {

    public function documentList() {
        try {
            $url = 'https://raw.githubusercontent.com/RashitKhamidullin/Educhain-Assignment/refs/heads/main/get-documents';

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_RETURNTRANSFER => true,
            ]);

            $rawResponse = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);

            if ($info['http_code'] === 200) {
                $response = json_decode($rawResponse, true);
                $filePath = 'uploadedFiles';
                if (!is_dir($filePath)) {
                    mkdir($filePath);
                }
                foreach ($response as $key => $res) {
                    $b64 = $res['certificate'];
                    $bin = base64_decode($b64);
                    $uploadedFilePath = 'public/' . $filePath . '/' . $res['description'] . '_' . $res['doc_no'] . '.' . 'pdf';
                    $img_file = __DIR__ . '/../../' . $uploadedFilePath;
                    if (!file_put_contents($img_file, $bin)) {
                        $response[$key]['fileUploaded'] = 'passed';
                    } else {
                        $response[$key]['fileUploaded'] = 'failed';
                    }
                    $response[$key]['certificate'] = $uploadedFilePath;
                }
                return $response;
            }
        } catch (Exception $e) {
            echo 'Message ' . $e->getMessage();
        }
    }
}

?>