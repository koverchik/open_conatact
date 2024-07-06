<?php
include 'ConfigurationDB.php';
function sendRequest($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $response;
}

function saveResponseToDb($pdo, $response) {
    $arrayResponse = json_decode($response);

    foreach ($arrayResponse as $item) {
        var_dump(get_object_vars($item));
        $item = get_object_vars($item);
        $date = (new DateTime($item['Date']))->format('m.d.y H:i:s');
        $sql = "INSERT INTO nbrb (cur_id, date_object, cur_abbreviation, cur_scale, cur_name, cur_official_rate)
                VALUES ({$item['Cur_ID']}, 
                        \"{$date}\", 
                        \"{$item['Cur_Abbreviation']}\", 
                        {$item['Cur_Scale']},  
                        \"{$item['Cur_Name']}\", 
                        {$item['Cur_OfficialRate']})";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
}
$url = 'https://api.nbrb.by/exrates/rates?periodicity=0';

$response = sendRequest($url);

if ($response !== false) {
    saveResponseToDb($pdo, $response);
    echo "Response saved to the database.";
} else {
    echo "Failed to get a valid response.";
}