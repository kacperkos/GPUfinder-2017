<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; Delete GPU</h1>';
echo '<hr />';
if(isset($_GET['id']) && isset($_GET['confirmation']) && $_GET['confirmation'] == 'no') {
    // GPU deletion NOT confirmed
    $card = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
    $row = mysqli_fetch_row($card);
    echo '<p><b>Attention:</b> Are you sure you want to delete this GPU <b>'.$row[1].'</b> and all data related to it?</p>
    <p><a href="cards_list.php">No</a></p>
    <p><a href="cards_list_delete.php?id='.$_GET['id'].'&confirmation=yes">Yes, I want to delete this GPU</a><br/>';
} elseif(isset($_GET['id']) && isset($_GET['confirmation']) && $_GET['confirmation'] == 'yes') {
    // GPU deletion confirmed
    $mysqli->query("DELETE FROM card WHERE id = ".$_GET['id']."");
    $mysqli->query("DELETE FROM hashrate WHERE card_id = ".$_GET['id']."");
    $mysqli->query("DELETE FROM offer WHERE card_id = ".$_GET['id']."");
    header('Location: cards_list.php?action=card_deleted');
    exit();
}
include 'inc/footer.php';