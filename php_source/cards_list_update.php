<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
if(isset($_GET['id']) && isset($_POST['card_name']) && isset($_POST['card_power'])) {
    // If form sent data, update GPU
    $mysqli->query("UPDATE card SET name = '".$_POST["card_name"]."', power = ".$_POST["card_power"]." WHERE id = ".$_GET['id']."");
    if($mysqli->errno) {
        echo '<p>Error: GPU hasn\'t been updated (' . $mysqli->errno . ') ' . $mysqli->error . '</p>';
        echo '<p><a href="cards_list.php">&#9668; GPUs list</a></p>';
    } else {
        header('Location: cards_list.php?action=card_edited');
        exit();
    }
} elseif(isset($_GET['id']) && !isset($_POST['card_name']) && !isset($_POST['card_power'])) {
    // If form didn't send data to update GPU, display form with current data
    echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; Edit GPU</h1>';
    echo '<hr />';
    // Display GPU Name
    $card = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
    $row = mysqli_fetch_row($card);
    echo '<p><b>'.$row[1].'</b></p>';
    echo '<form name="addNewCard" method="POST" action="cards_list_update.php?id='.$_GET['id'].'" onsubmit="return validateAddNewCardForm()">
    <p>GPU Name: <input name="card_name" size="50" value="'.$row[1].'" /> GPU Power (W): <input name="card_power" type="number" value="'.$row[3].'"/> <input type="submit" value="Update" /></p>
    </p></form>';
}
include 'inc/footer.php';