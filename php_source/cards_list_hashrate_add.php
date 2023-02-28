<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
if(isset($_GET['id']) && isset($_POST['hashrate_crypto']) && isset($_POST['hashrate_hashrate'])) {
    // If form sent data, add new Hashrate
    $mysqli->query("INSERT INTO hashrate(card_id, crypto_id, hashrate) VALUES (".$_GET['id'].", '".$_POST['hashrate_crypto']."', ".$_POST['hashrate_hashrate'].")");
    if($mysqli->errno) {
        echo '<p>Error: Hashrate hasn\'t been added (' . $mysqli->errno . ') ' . $mysqli->error . '</p>';
        echo '<p><a href="cards_list_hashrate.php?id='.$_GET['id'].'">&#9668; Hashrates list</a></p>';
    } else {
        header('Location: cards_list_hashrate.php?id='.$_GET['id'].'&action=hashrate_added');
        exit();
    }
} elseif(isset($_GET['id'])) {
    // If no data was sent for new Hashrate, display form
    echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; <a href="cards_list_hashrate.php?id='.$_GET['id'].'">Edit GPU Hashrate</a> &#9658; Add new Hashrate</h1>';
    echo '<hr />';	
    // Display GPU Name
    $card = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
    $row = mysqli_fetch_row($card);
    echo '<p><b>'.$row[1].'</b></p>';		
    // Form
    echo '<form name="addNewHashrate" method="POST" action="cards_list_hashrate_add.php?id='.$_GET['id'].'" onsubmit="return validateAddNewHashrateForm()">
    <p>Cryptocurrency: 
    <select name="hashrate_crypto"><option value=""></option>';
    // Cryptocurrencies drop-down
    $cryptos = $mysqli->query("SELECT * FROM crypto ORDER BY name");
    while($crypto = mysqli_fetch_array($cryptos)) {
        echo '<option value="'.$crypto[0].'">'.$crypto[1].' ('.$crypto[2].')</option>';
    }
    echo '</select> Hashrate (Mh/s): <input name="hashrate_hashrate" type="number" step="any" /> <input type="submit" value="Add" /></p>
    </form>';
}

include 'inc/footer.php';