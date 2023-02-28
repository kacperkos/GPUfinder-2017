<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
if(isset($_POST['crypto_symbol']) && isset($_POST['crypto_name']) && isset($_POST['crypto_price']) && isset($_POST['crypto_efficiency'])) {
    // If form sent data, add new crytocurrency
    $mysqli->query("INSERT INTO crypto(name, symbol, price, efficiency) VALUES ('".$_POST['crypto_name']."', '".$_POST['crypto_symbol']."', ".$_POST['crypto_price'].", ".$_POST['crypto_efficiency'].")");
    if($mysqli->errno) {
        echo '<p>Error: cryptocurrency hasn\'t been added (' . $mysqli->errno . ') ' . $mysqli->error . '</p>';
        echo '<p><a href="crypto_list.php">&#9668; Cryptocurrencies list</a></p>';
    } else {
        header('Location: crypto_list.php?action=crypto_added');
        exit();
    }
} else {
    // If form didn't send data for new cryptocurrency, display form
    echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="crypto_list.php">Cryptocurrencies list</a> &#9658; Add new cryptocurrency</h1>';
    echo '<hr />';
    echo '<form name="addNewCrypto" method="POST" action="crypto_list_add.php" onsubmit="return validateAddNewCryptoForm()">
    <p>Symbol: <input id="cryptoSymbol" name="crypto_symbol" size="5"/> Name: <input name="crypto_name" type="text" size="50" /> Price ('.$GLOBALS['currency_symbol'].'): <input name="crypto_price" type="number" step="0.01" size="10" /> Extraction per hour at 10 Mh/s: <input name="crypto_efficiency" type="number" step="any" size="10" />
    <input type="submit" value="Add" /></p>
    </p></form>';
}
include 'inc/footer.php';