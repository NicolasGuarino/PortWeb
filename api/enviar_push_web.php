<?php
    function enviar_push_web($notification, $lista_token) {
        $lista_token = array_diff($lista_token, ['']);
        
        $json_data = array(
            'notification' => $notification,
            'registration_ids' => json_encode($lista_token)
        );
        
        $data = json_encode($json_data);
    
        // API do Firebase 
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        // Chave do server
        // $server_key = 'AAAACupSSgA:APA91bG89KQ8U_8z4GmxfnVpEIhEBA9hdbKHBKsyFtvmufPQIBnTSAmTQoMarIUP7h0jT0Yb5Qm_eok6B6JggCcEt6okoUInbCJLMavq-80mTI64jd9e9VFOlClS_mnLwQCIox_DOl9t'; // CHAVE DO PORTARIA
        $server_key = 'AAAAcgAcsFU:APA91bFz0iRWEPfN3kax56X5uK0cn8dcKdSmSWXXozG4-L69RL1_byzpfda0FmYVtTfwyQh09pv2HDCUjnEkoBC10C0qEyA_ZG-IWZ6dwd2GTVjFy8PnrXZuCHbCAtbDEHg3LQElo4jF'; // CHAVE DO AUDITORIA
        
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
    
        // Utilizando o CURL para requisitar a API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // URL
        curl_setopt($ch, CURLOPT_POST, true); // POST
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // HEADERS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // DATA
    
        $result = curl_exec($ch);
    
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }else{
            echo $result;
        }
    
    
        curl_close($ch);
    }
?>