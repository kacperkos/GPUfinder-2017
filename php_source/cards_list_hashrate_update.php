<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
if(isset($_GET['id']) && isset($_GET['hashrate_id']) && isset($_POST['hashrate_crypto']) && isset($_POST['hashrate_hashrate'])) {
    // If form passed data, edit Hashrate
    $mysqli->query("UPDATE hashrate SET crypto_id = ".$_POST['hashrate_crypto'].", hashrate = ".$_POST['hashrate_hashrate']." WHERE id = ".$_GET['hashrate_id']."");
    if($mysqli->errno) {
        echo '<p>Error: Hashrate hasn\'t been updated (' . $mysqli->errno . ') ' . $mysqli->error . '</p>';
        echo '<p><a href="cards_list_hashrate.php?id='.$_GET['id'].'">&#9668; Hashrate list</a></p>';
    } else {
        header('Location: cards_list_hashrate.php?id='.$_GET['id'].'&action=hashrate_edited');
        exit();
    }
} elseif(isset($_GET['id']) && isset($_GET['hashrate_id']) && !isset($_POST['hashrate_crypto']) && !isset($_POST['hashrate_hashrate'])) {
    // If updated data hasn't been send, display form with current data
    echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; <a href="cards_list_hashrate.php?id='.$_GET['id'].'">Edit GPU Hashrate</a> &#9658; Edit Hashrate</h1>';
    echo '<hr />';	
    // Display GPU Name
    $card = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
    $row = mysqli_fetch_row($card);
    echo '<p><b>'.$row[1].'</b></p>';		
    // Display form with current data
    $hashrates = $mysqli->query("SELECT * FROM hashrate WHERE id = ".$_GET['hashrate_id']."");
    $hashrate = mysqli_fetch_array($hashrates);
    echo '<form name="addNewHashrate" method="POST" action="cards_list_hashrate_update.php?id='.$_GET['id'].'&hashrate_id='.$_GET['hashrate_id'].'" onsubmit="return validateAddNewHashrateForm()">
    <p>Cryptocurrency: 
    <select name="hashrate_crypto"><option value=""></option>';
    // Cryptocurrencies drop-down
    $cryptos = $mysqli->query("SELECT * FROM crypto ORDER BY name");
    while($crypto = mysqli_fetch_array($cryptos)) {
        if($crypto[0] == $hashrate[2]) {
            echo '<option value="'.$crypto[0].'" selected>'.$crypto[1].' ('.$crypto[2].')</option>';
        } else {
            echo '<option value="'.$crypto[0].'">'.$crypto[1].' ('.$crypto[2].')</option>';
        }
    }
    echo '</select> Hashrate (Mh/s): <input name="hashrate_hashrate" type="number" step="any" value="'.$hashrate[3].'" /> <input type="submit" value="Update" /></p>
    </form>';
}
include 'inc/footer.php';