<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
echo '<p id="messageTxt"><br />Here\'s welcoming message!<br /><br /><a onclick="hideMessage();">CLOSE [X]</a><br /><br /></p>';
echo '<h1><b>GPU</b>finder</h1>';
echo '<hr />';
echo '<p><a href="cards_list.php">&#9658; GPUs list</a></p>';
echo '<p><a href="crypto_list.php">&#9658; Cryptocurrencies list</a></p>';
echo '<hr />';
// Display GPUs list
$cards = $mysqli->query("SELECT * FROM card ORDER BY name ASC");
echo '<table>
<tr class="firstTR">
    <td>GPU ID</td>
    <td>GPU Name</td>';
    // Displaying columns Price/Efficiency and GPU pay off for each cryptocurrency
    $cryptos = $mysqli->query("SELECT * FROM crypto ORDER BY name ASC");
    while ($crypto = mysqli_fetch_array($cryptos)) {
        echo '<td>Price/Efficiency ('.$crypto[2].')</td><td>GPU pay off ('.$crypto[2].')</td>';			
    }
echo '<td>Best buy offer</td></tr>';
while($card = mysqli_fetch_row($cards)) {
    echo '<tr>
    <td>'.$card[0].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$card[1].'&nbsp;&nbsp;&nbsp;</td>';
    // Calculating values for columns Price/Efficiency and GPU pay off for each cryptocurrency
    $cryptos = $mysqli->query("SELECT * FROM crypto ORDER BY name ASC");
    while ($crypto = mysqli_fetch_array($cryptos)) {
        echo '<td class="cryptoColor1">'.getPriceEfficiencyRatio($card[0], $crypto[0]).'&nbsp;&nbsp;&nbsp;</td>
        <td class="cryptoColor2">'.getCardReturnTime($card[0], $crypto[0]).'&nbsp;&nbsp;&nbsp;</td>';
    }
    echo '<td>';
    // Best GPU buy offer
    $best_offer = $mysqli->query("SELECT * FROM offer WHERE card_id = ".$card[0]." ORDER BY price ASC LIMIT 1");
    $row = mysqli_fetch_row($best_offer);
    if($row == NULL) {
        echo '<span style="color: grey">...</span>';
    } else {
        echo $row[4] . ' '.$GLOBALS['currency_symbol'].' ('.$row[2].')'.getOfferLink($row[3], $row[2]);
    }
    echo '&nbsp;&nbsp;&nbsp;</td>
    </tr>';
}
// Additional informations
echo '</table>
<hr />
<p>Information: Columns "Price/Efficiency" and "GPU pay off" will be displayed only if at least 1 cryptocurrency has been added</p>
<p>Information: Calculating values "Price/Efficienct" and "GPU pay off" is possible only if GPU has at lease 1 buy offer and 1 Hashrate</p>
<p>Information: How to read calculations?<br />- Price/Efficiency: the smaller the better<br />- GPU pay off: the shorter the better</p>
<script>checkMessageCookie();</script>';
include 'inc/footer.php';