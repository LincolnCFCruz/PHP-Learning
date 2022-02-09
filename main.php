<?php
$url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml?5105e8233f9433cf70ac379d6';
$xml = simplexml_load_file($url);

foreach($xml->Cube as $node) {
    $items = $node->children();

    foreach($items as $item){
        foreach($item as $elem){
            $currencyXML[] = sprintf('%s %s %s', $elem->attributes->currency, $elem->attributes()->currency, $elem);
        }
        foreach($item as $elem){
            $rateXML[] = sprintf('%s %s %s', $elem->attributes->rate, $elem->attributes()->rate, $elem);
        }
    }
}

$date = date("Y-m-d");
$fh = fopen("usd_currency_rates_$date.csv", "w");

$length = count($currencyXML);

$num = '0';

while($num < $length) {
    print_r($currencyXML[$num]);
    fwrite($fh,$currencyXML[$num]);
    print_r($rateXML[$num]);
    fwrite($fh,$rateXML[$num]."\r\n");

    $num++;
}

fclose($fh);

?>