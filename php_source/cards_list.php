<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
// If new GPU has been added, show message
if(isset($_GET['action']) && $_GET['action'] == 'card_added') {
    echo '<script>alert("Information: New GPU has been added");</script>';
}
// If GPU has been deleted, show message
if(isset($_GET['action']) && $_GET['action'] == 'card_deleted') {
    echo '<script>alert("Information: GPU has been deleted");</script>';
}
// IF GPU has been edited, show message
if(isset($_GET['action']) && $_GET['action'] == 'card_edited') {
    echo '<script>alert("Information: GPU data has been updated");</script>';
}
echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; GPUs list</h1>';
echo '<hr />';
echo '<p><a href="cards_list_add.php" >&#9658; Add new GPU</a></p>';
echo '<hr />';	
// Displaying GPUs list
$cards = $mysqli->query("SELECT * FROM card ORDER BY name ASC");
echo '<table>
<tr class="firstTR">
    <td>GPU ID</td>
    <td>GPU Name</td>
    <td>GPU Power</td>';
    // Displaying Hashrate column for each cryptocurrency
    $cryptos = $mysqli->query("SELECT * FROM crypto ORDER BY name ASC");
    while ($crypto = mysqli_fetch_array($cryptos)) {
        echo '<td>Hashrate ('.$crypto[2].')</td>';
    }
    echo '<td>Best buy offer</td>
    <td>Action</td>
</tr>';
while($card = mysqli_fetch_row($cards)) {
    echo '<tr>
    <td>'.$card[0].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$card[1].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$card[3].' W&nbsp;&nbsp;&nbsp;</td>';
    // Displaying Hashrate column for each cryptocurrency
    $cryptos = $mysqli->query("SELECT * FROM crypto ORDER BY name ASC");
    while ($crypto = mysqli_fetch_array($cryptos)) {
        echo '<td>'.getAverageHashrate($card[0], $crypto[0], 'text').'&nbsp;&nbsp;&nbsp;</td>';
    }
    // Best offer for GPU
    $best_offer = $mysqli->query("SELECT * FROM offer WHERE card_id = ".$card[0]." ORDER BY price ASC LIMIT 1");
    $row = mysqli_fetch_row($best_offer);
    echo '<td>';
    if($row == NULL) {
        echo '<span style="color: grey">...</span>';
    } else {
        echo $row[4] . ' '.$GLOBALS['currency_symbol'].' ('.$row[2].')'.getOfferLink($row[3], $row[2]);
    }	
    echo '&nbsp;&nbsp;&nbsp;</td>
    <td><a href="cards_list_hashrate.php?id='.$card[0].'">[hashrate]</a><a href="cards_list_offer.php?id='.$card[0].'">[buy offers]</a><a href="cards_list_update.php?id='.$card[0].'">[edit]</a><a href="cards_list_delete.php?id='.$card[0].'&confirmation=no">[delete]</a>&nbsp;&nbsp;&nbsp;</td>
    </tr>';
}
echo '</table>';
include 'inc/footer.php';