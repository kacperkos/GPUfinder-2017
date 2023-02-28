<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; <a href="cards_list_hashrate.php?id='.$_GET['id'].'">Edit GPU Hashrate</a> &#9658; Delete GPU Hashrate</h1>';
echo '<hr />';
if(isset($_GET['id']) && isset($_GET['hashrate_id']) && isset($_GET['confirmation']) && $_GET['confirmation'] == 'no') {
    // Hashrate deletion NOT confirmed
    $cards = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
    $card = mysqli_fetch_row($cards);
    $hashrates = $mysqli->query("SELECT * FROM hashrate WHERE id = ".$_GET['hashrate_id']."");
    $hashrate = mysqli_fetch_row($hashrates);
    $cryptos = $mysqli->query("SELECT * FROM crypto WHERE id = ".$hashrate[2]."");
    $crypto = mysqli_fetch_row($cryptos);
    echo '<p><b>Attention:</b> Are you sure you want to delete this Hashrate <b>'.$hashrate[3].' Mh/s</b> of cryptocurrency <b>'.$crypto[1].' ('.$crypto[2].')</b> for GPU <b>'.$card[1].'</b>?</p>
    <p><a href="cards_list_hashrate.php?id='.$_GET['id'].'">No</a></p>
    <p><a href="cards_list_hashrate_delete.php?id='.$_GET['id'].'&hashrate_id='.$_GET['hashrate_id'].'&confirmation=yes">Yes, I want to delete this Hashrate</a><br/>';
} elseif(isset($_GET['id']) && isset($_GET['hashrate_id']) && isset($_GET['confirmation']) && $_GET['confirmation'] == 'yes') {
    // Hashrate deletion confirmed
    $mysqli->query("DELETE FROM hashrate WHERE id = ".$_GET['hashrate_id']." AND card_id = ".$_GET['id']."");
    header('Location: cards_list_hashrate.php?id='.$_GET['id'].'&action=hashrate_deleted');
    exit();
}
include 'inc/footer.php';