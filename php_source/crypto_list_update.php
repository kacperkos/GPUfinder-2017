<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
if(isset($_GET['crypto_id']) && isset($_POST['crypto_symbol']) && isset($_POST['crypto_name']) && isset($_POST['crypto_price']) && isset($_POST['crypto_efficiency'])) {
    // If form sent data, add new cryptocurrency
    $mysqli->query("UPDATE crypto SET name = '".$_POST['crypto_name']."', symbol = '".$_POST['crypto_symbol']."', price = ".$_POST['crypto_price'].", efficiency = ".$_POST['crypto_efficiency']." WHERE id = ".$_GET['crypto_id']."");
    if($mysqli->errno) {
        echo '<p>Error: cryptocurrency hasn\'t been updated (' . $mysqli->errno . ') ' . $mysqli->error . '</p>';
        echo '<p><a href="crypto_list.php">&#9668; Cryptocurrencies list</a></p>';
    } else {
        header('Location: crypto_list.php?action=crypto_edited');
        exit();
    }
} elseif(isset($_GET['crypto_id']) && !isset($_POST['crypto_symbol']) && !isset($_POST['crypto_name']) && !isset($_POST['crypto_price']) && !isset($_POST['crypto_efficiency'])) {
    // If form didn't send data to update cryptocurrency, display form with current data
    echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="crypto_list.php">Cryptocurrencies list</a> &#9658; Edit cryptocurrency</h1>';
    echo '<hr />';
    // Display cryptocurrency name
    $crypto = $mysqli->query("SELECT * FROM crypto WHERE id = ".$_GET['crypto_id']."");
    $row = mysqli_fetch_array($crypto);
    echo '<p><b>'.$row[1].' ('.$row[2].')</b></p>';
    echo '<form name="addNewCrypto" method="POST" action="crypto_list_update.php?crypto_id='.$_GET['crypto_id'].'" onsubmit="return validateAddNewCryptoForm()">
    <p>Symbol: <input id="cryptoSymbol" name="crypto_symbol" size="5" value="'.$row[2].'" /> Name: <input name="crypto_name" type="text" size="50" value="'.$row[1].'" /> Price ('.$GLOBALS['currency_symbol'].'): <input name="crypto_price" type="number" step="0.01" size="10" value="'.$row[3].'" /> Extraction per hour at 10 Mh/s: <input name="crypto_efficiency" type="number" step="any" size="10" value="'.$row[4].'" />
    <input type="submit" value="Update" /></p>
    </p></form>';
}
include 'inc/footer.php';