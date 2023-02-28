<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; <a href="cards_list_offer.php?id='.$_GET['id'].'">Edit GPU buy offers</a> &#9658; Delete buy offer</h1>';
echo '<hr />';
if(isset($_GET['id']) && isset($_GET['offer_id']) && isset($_GET['confirmation']) && $_GET['confirmation'] == 'no') {
    // Offer deletion NOT confirmed
    $card = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
    $row = mysqli_fetch_row($card);
    $offer = $mysqli->query("SELECT * FROM offer WHERE id = ".$_GET['offer_id']."");
    $row2 = mysqli_fetch_row($offer);
    echo '<p><b>Attention:</b> Are you sure you wan\'t to deleted offer <b>'.$row2[4].' '.$GLOBALS['currency_symbol'].'</b> from <b>'.$row2[2].'</b> for GPU <b>'.$row[1].'</b>?</p>
    <p><a href="cards_list_offer.php?id='.$_GET['id'].'">No</a></p>
    <p><a href="cards_list_offer_delete.php?id='.$_GET['id'].'&offer_id='.$_GET['offer_id'].'&confirmation=yes">Yes, I want to delete this offer</a><br/>';
} elseif(isset($_GET['id']) && isset($_GET['offer_id']) && isset($_GET['confirmation']) && $_GET['confirmation'] == 'yes') {
    // Offer deletion confirmed
    $mysqli->query("DELETE FROM offer WHERE id = ".$_GET['offer_id']." AND card_id = ".$_GET['id']."");
    header('Location: cards_list_offer.php?id='.$_GET['id'].'&action=offer_deleted');
    exit();
}
include 'inc/footer.php';