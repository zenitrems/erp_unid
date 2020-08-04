<?php
require_once "database.php";

/* funcion api_get con curl  para consultar api */
function api_get($url, $request = array(), $content = 'text/json')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo '<hr/>Curl error: ' . curl_error($ch) . '<hr/>';
    }
    curl_close($ch);
    return json_decode($response, true);
}

/* se consultan los tipos de cambio regresa un arreglo*/
$mxnusd = api_get('https://api.cambio.today/v1/quotes/MXN/USD/json?quantity=1&key=4496|wQcZYb5EW2LBg4vPM~OZ4yH*Rc5BVzs0');
$usdmxn = api_get('https://api.cambio.today/v1/quotes/USD/MXN/json?quantity=1&key=4496|wQcZYb5EW2LBg4vPM~OZ4yH*Rc5BVzs0');
$mxneur = api_get('https://api.cambio.today/v1/quotes/MXN/EUR/json?quantity=1&key=4496|wQcZYb5EW2LBg4vPM~OZ4yH*Rc5BVzs0');
$eurmxn = api_get('https://api.cambio.today/v1/quotes/EUR/MXN/json?quantity=1&key=4496|wQcZYb5EW2LBg4vPM~OZ4yH*Rc5BVzs0');
$usdeur = api_get('https://api.cambio.today/v1/quotes/USD/EUR/json?quantity=1&key=4496|wQcZYb5EW2LBg4vPM~OZ4yH*Rc5BVzs0');
$eurusd = api_get('https://api.cambio.today/v1/quotes/EUR/USD/json?quantity=1&key=4496|wQcZYb5EW2LBg4vPM~OZ4yH*Rc5BVzs0');

/* se arreglan los datos requeridos*/
$currenciesAPI = array(
    'MXN/USD' => array(
        $mxnusd['result']['value'],
        $mxnusd['result']['source'],
        $mxnusd['result']['target'],
        $mxnusd['result']['updated']
    ),
    'USD/MXN' => array(
        $usdmxn['result']['value'],
        $usdmxn['result']['source'],
        $usdmxn['result']['target'],
        $usdmxn['result']['updated']
    ),
    'MXN/EUR' => array(
        $mxneur['result']['value'],
        $mxneur['result']['source'],
        $mxneur['result']['target'],
        $mxneur['result']['updated']
    ),
    'EUR/MXN' => array(
        $eurmxn['result']['value'],
        $eurmxn['result']['source'],
        $eurmxn['result']['target'],
        $eurmxn['result']['updated']
    ),
    'USD/EUR' => array(
        $usdeur['result']['value'],
        $usdeur['result']['source'],
        $usdeur['result']['target'],
        $usdeur['result']['updated']
    ),
    'EUR/USD' => array(
        $eurusd['result']['value'],
        $eurusd['result']['source'],
        $eurusd['result']['target'],
        $eurusd['result']['updated']
    ),
);

/* se recorren los arreglos y se incertan en la bd*/
foreach ($currenciesAPI as $row) {
    $value = $row[0];
    $source = $row[1];
    $target = $row[2];
    $updated = $row[3];

    $query = "INSERT INTO multimoneda (source, target, value, updated) VALUES('$source','$target','$value','$updated')";
    mysqli_query($mysqli, $query);
}
