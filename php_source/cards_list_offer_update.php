<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
if(isset($_GET['id']) && isset($_GET['offer_id']) && isset($_POST['offer_price']) && isset($_POST['offer_source']) && isset($_POST['offer_id'])) {
    // If form sent data, add new buy offer
    $mysqli->query("UPDATE offer SET source = '".$_POST['offer_source']."', source_id = ".$_POST['offer_id'].", price = ".$_POST['offer_price']." WHERE id = ".$_GET['offer_id']."");
    if($mysqli->errno) {
        echo '<p>Błąd: nie edytowano oferty (' . $mysqli->errno . ') ' . $mysqli->error . '</p>';
        echo '<p><a href="cards_list_offer.php?id='.$_GET['id'].'">&#9668; Buy offers list</a></p>';
    } else {
        header('Location: cards_list_offer.php?id='.$_GET['id'].'&action=offer_edited');
        exit();
    }
} elseif(isset($_GET['id']) && isset($_GET['offer_id']) && !isset($_POST['offer_price']) && !isset($_POST['offer_source']) && !isset($_POST['offer_id'])) {
    // If form didn't send data of new offer, display form
    echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; <a href="cards_list_offer.php?id='.$_GET['id'].'">Edit GPU buy offers</a> &#9658; Edit buy offer</h1>';
    echo '<hr />';	
    // Display GPU Name
    $card = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
    $row = mysqli_fetch_row($card);
    echo '<p><b>'.$row[1].'</b></p>';
    // Form filled with current data
    $offer = $mysqli->query("SELECT * FROM offer WHERE id = ".$_GET['offer_id']." AND card_id = ".$_GET['id']."");
    $row2 = mysqli_fetch_array($offer);
    echo '<form name="addNewOffer" method="POST" action="cards_list_offer_update.php?id='.$_GET['id'].'&offer_id='.$_GET['offer_id'].'" onsubmit="return validateAddNewOfferForm()">
    <p>Price ('.$GLOBALS['currency_symbol'].'): <input name="offer_price" type="number" value="'.$row2[4].'" /> Source:
    <select name="offer_source"><option value=""></option>';
    $offer_sources = explode(',', $GLOBALS['offer_sources']);
    $offer_sources_lenght = count($offer_sources);
    for($i=0; $i<$offer_sources_lenght; $i++) {
        if($row2[2] == $offer_sources[$i]) {
            echo '<option value="'.$offer_sources[$i].'" selected>'.$offer_sources[$i].'</option>';
        } else {
            echo '<option value="'.$offer_sources[$i].'">'.$offer_sources[$i].'</option>';
        }
    }	
    echo '</select>
    External offer ID: <input name="offer_id" type="number" value="'.$row2[3].'" /> <input type="submit" value="Update" /></p>
    </p></form>';
}
include 'inc/footer.php';