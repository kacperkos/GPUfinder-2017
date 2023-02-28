<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="crypto_list.php">Cryptocurrencies list</a> &#9658; Delete cryptocurrency</h1>';
echo '<hr />';
if(isset($_GET['crypto_id']) && isset($_GET['confirmation']) && $_GET['confirmation'] == 'no') {
    // Cryptocurrency deletion NOT confirmed
    $crypto = $mysqli->query("SELECT * FROM crypto WHERE id = ".$_GET['crypto_id']."");
    $row = mysqli_fetch_row($crypto);
    echo '<p><b>Attention:</b> Are you sure you wan\'t to delete cryptocurrency <b>'.$row[1].' ('.$row[2].')</b>?</p>
    <p><a href="crypto_list.php">No</a></p>
    <p><a href="crypto_list_delete.php?crypto_id='.$_GET['crypto_id'].'&confirmation=yes">Yes, I wan\'t to delete this cryptocurrency</a><br/>';
} elseif(isset($_GET['crypto_id']) && isset($_GET['confirmation']) && $_GET['confirmation'] == 'yes') {
    // Cryptocurrency deletion confirmed
    $mysqli->query("DELETE FROM crypto WHERE id = ".$_GET['crypto_id']."");
    header('Location: crypto_list.php?action=crypto_deleted');
    exit();
}
include 'inc/footer.php';