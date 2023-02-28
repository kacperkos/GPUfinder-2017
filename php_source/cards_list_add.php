<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
if(isset($_POST['card_name']) && isset($_POST['card_power'])) {
    // If form passed data, add new GPU
    $mysqli->query("INSERT INTO card(name, hashrate, power) VALUES ('".$_POST["card_name"]."',0 , ".$_POST["card_power"].")");
    if($mysqli->errno) {
        echo '<p>Error: GPU hasn\'t been added (' . $mysqli->errno . ') ' . $mysqli->error . '</p>';
        echo '<p><a href="cards_list.php">&#9668; GPUs list</a></p>';
    } else {
        header('Location: cards_list.php?action=card_added');
        exit();
    }
} else {
    // If no data was passed for new GPU, display form
    echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; Add new GPU</h1>';
    echo '<hr />';
    echo '<form name="addNewCard" method="POST" action="cards_list_add.php" onsubmit="return validateAddNewCardForm()">
    <p>GPU Name: <input name="card_name" size="50"/> GPU Power (W): <input name="card_power" type="number" /> <input type="submit" value="Add" /></p>
    </p></form>';
}
include 'inc/footer.php';