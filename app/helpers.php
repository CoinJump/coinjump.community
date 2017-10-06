<?php
function fetchJson(string $url): array
{
    $response = (new GuzzleHttp\Client())
        ->get($url)
        ->getBody();

    return json_decode($response, true);
}

function priceJumpPercentage($value1, $value2) {
    // Because some units have such low values (ie: 0.000013$ per unit)
    // it doesn't cut it to just multiple by 100, it'll always return 0%.
    // Increase the number first, compare then.

    $multiplier = 10000;
    $fullValue1 = $value1 * $multiplier;
    $fullValue2 = $value2 * $multiplier;

    if ($value2 != 0) {
        return 100 - round($fullValue1 / $fullValue2 * 100, 2);
    } else {
        return false;
    }
}
?>
