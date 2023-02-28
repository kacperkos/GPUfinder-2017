<?php
// Function returns amount after tax
// Tax can be changed in inc/config.php
function taxed(float $amount) {
    $amount_taxed = NULL;
    $amount_taxed = $amount-($amount*$GLOBALS['tax']);
    return $amount_taxed;
}
// Function constructs external hyperlink for GPU source and offer ID
function getOfferLink(int $id, string $source) {
$link = NULL;
switch($source) {
    case 'Allegro':
        $link = '<a href="http://www.allegro.pl/i'.$id.'.html" target="_blank">[see]</a>';
        break;
    case 'Morele':
        $link = '<a href="http://www.morele.net/a-'.$id.'" target="_blank">[see]</a>';
        break;
    case 'X-KOM':
        $link = '<a href="http://www.x-kom.pl/p/'.$id.'.html" target="_blank">[see]</a>';
        break;
    case 'OLX':
        $link = '<a href="http://www.olx.pl/'.$id.'" target="_link">[see]</a>';
        break;
    case 'ProLine':
        $link = '<a href="http://www.proline.pl/a-p'.$id.'" target="_blank">[see]</a>';
        break;
    case 'Sferis':
        $link = '<a href="http://www.sferis.pl/a-p'.$id.'" target="_blank">[see]</a>';
        break;
}
return $link;
}
// Function calculates average hashrate for specific GPU and cryptocurrency
// 3rd parametrs value could be:
// "text" -> result will be string Mh/s or ...
// "number" -> result will be numeric
function getAverageHashrate(int $card_id, int $crypto_id, string $result_type) {
    include 'inc/dbconnect.php';
    $hashrates = $mysqli->query("SELECT * FROM hashrate WHERE card_id = ".$card_id." AND crypto_id = ".$crypto_id."");
    $hashrate_counter = 0;
    $hashrate_total = 0;
    $hashrate_average = 0;
    $hashrate_average_text = '';
    while($hashrate = mysqli_fetch_array($hashrates)) {
        $hashrate_total += $hashrate[3];
        $hashrate_counter++;
    }
    // Calculating average and constructing result as (eventual) string
    if($hashrate_counter == 0) {
        $hashrate_average_text = '<span style="color: grey">...</span>';
        $hashrate_average = 0;
    } else {
        $hashrate_average = $hashrate_total/$hashrate_counter;
        $hashrate_average_text = round($hashrate_average, 2) . ' Mh/s';
    }
    // Result returning
    if($result_type == 'text') {
            return $hashrate_average_text;
    } elseif($result_type = 'number') {
            return $hashrate_average;
    } else {
            return NULL;
    }
}
// Function calculates Purchase Price to Efficiency ratio (the smaller the better)
// Efficiency is GPU Hashrate to GPU Power ratio (the bigger the better)
function getPriceEfficiencyRatio(int $card_id, int $crypto_id) {
    include 'inc/dbconnect.php';
    $card_power = 0;
    $card_hashrate = 0;
    $card_price = 0;
    $card_efficiency_per_wat = 0;
    $card_price_efficiency_ratio = 0;
    //Moc karty
    $cards = $mysqli->query("SELECT * FROM card WHERE id = ".$card_id."");
    $card = mysqli_fetch_array($cards);
    $card_power = $card[3];
    // GPU hashrate
    $card_hashrate = getAverageHashrate($card_id, $crypto_id, 'number');
    if(!$card_hashrate) {
        // IF GPU doesn't have Hashrate, return ...
        return '<span style="color: grey">...</span>';
    } else {
        // IF GPU has Hasrhrate, keep calculating
        // Best buy offer
        $offers = $mysqli->query("SELECT * FROM offer WHERE card_id = ".$card_id." ORDER BY price ASC LIMIT 1");
        $offer = mysqli_fetch_array($offers);
        if(!$offer) {
            // If there's no buy offer, return ...
            return '<span style="color: grey">...</span>';
        } else {
            // If there's buy offer, keep calculating
            $card_price = $offer[4];
            $card_efficiency_per_wat = $card_hashrate/$card_power;
            $card_price_efficiency_ratio = $card_price/$card_efficiency_per_wat;
            $card_price_efficiency_ratio /= 1000;
            $card_price_efficiency_ratio = round($card_price_efficiency_ratio, 2);
            return $card_price_efficiency_ratio;
        }
    }
}
// Functions calculates when GPU purchase will pay off (in days)
function getCardReturnTime($card_id, $crypto_id) {
    include 'inc/dbconnect.php';
    $power_price = 0;
    $card_power = 0;
    $card_price = 0;
    $card_hashrate = 0;
    $crypto_price = 0;
    $crypto_mining_efficiency = 0;
    $crypto_per_hour = 0;
    $pln_per_hour = 0;
    $power_cost_per_hour = 0;
    $profit_per_hour = 0;
    $card_return_in_hours = 0;
    $card_return_in_days = 0;
    // Collecting data
    // Energy price
    $power_price = $GLOBALS['power_price'];
    // GPU Power
    $cards = $mysqli->query("SELECT * FROM card WHERE id = ".$card_id."");
    $card = mysqli_fetch_array($cards);
    $card_power = $card[3];
    // GPU Price
    $offers = $mysqli->query("SELECT * FROM offer WHERE card_id = ".$card_id." ORDER BY price ASC LIMIT 1");
    $offer = mysqli_fetch_array($offers);
    if(!$offer) {
        // If there's no buy offer, return ...
        return '<span style="color: grey">...</span>';
    } else {
        // If there's buy offer, keep calculating
        $card_price = $offer[4];
        // GPU Hashrate
        $card_hashrate = getAverageHashrate($card_id, $crypto_id, 'number');
        if(!$card_hashrate) {
            // If GPU doesn't have any Hashrate, return ...
            return '<span style="color: grey">...</span>';
        } else {
            // If GPU has Hashrate, keep calculating
            // Price and cryptocurrency mining efficiency
            $cryptos = $mysqli->query("SELECT * FROM crypto WHERE id = ".$crypto_id."");
            $crypto = mysqli_fetch_array($cryptos);
            $crypto_price = $crypto[3];
            $crypto_mining_efficiency = $crypto[4];
            // Calculations:
            // How many (in specific currency) GPU will minein 1h
            $crypto_per_hour = $crypto_mining_efficiency*($card_hashrate/10);
            $pln_per_hour = $crypto_per_hour*$crypto_price;
            // Income after tax (energy price and purchase price not included)
            $pln_per_hour = taxed($pln_per_hour);
            // What is energy per hour cost for GPU?
            $power_cost_per_hour = $power_price*($card_power/1000);
            // What is profit per hour?
            $profit_per_hour = $pln_per_hour-$power_cost_per_hour;
            if($profit_per_hour <= 0) {
                // If GPU not generates profit (generated lose)
                return '<span style="color: red">never</span>';
            } else {
                // If GPU generates profit, keep calculating
                // After how many hours GPU will pay off?
                $card_return_in_hours = $card_price/$profit_per_hour;
                // After how many days GPU will pay off?
                $card_return_in_days = $card_return_in_hours/24;
                $card_return_in_days = round($card_return_in_days, 0);
                return '<span style="color: green">' . $card_return_in_days . ' day(s)</span>';
            }
        }
    }
}