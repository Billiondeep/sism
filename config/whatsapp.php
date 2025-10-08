<?php
// FILE: config/whatsapp.php
define('WHATSAPP_API_KEY', 'RMb9S8VR1c6QGUzonSK6YkqgaNxqU66U7nrDciVAvtxnyfT7u4');

function sendWhatsAppMessage($target, $message, $file_url = null) {
    if (WHATSAPP_API_KEY === 'RMb9S8VR1c6QGUzonSK6YkqgaNxqU66U7nrDciVAvtxnyfT7u4' || empty(WHATSAPP_API_KEY)) {
        error_log("WhatsApp API Key is not set.");
        return false; // Jangan kirim jika API Key belum diatur
    }
    
    // Pastikan nomor diawali 62
    if (substr($target, 0, 1) === '0') {
         $target = '62' . substr($target, 1);
    }

    $curl = curl_init();
    $payload = [ "target" => $target, "message" => $message ];

    if ($file_url) {
        $payload['url'] = $file_url;
        $payload['filename'] = "Surat Permohonan.pdf";
    }

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.fonnte.com/send",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $payload,
      CURLOPT_HTTPHEADER => array( "Authorization: " . WHATSAPP_API_KEY ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    if ($err) {
        error_log("cURL Error #:" . $err);
        return false;
    }
    
    return json_decode($response, true);
}
?>