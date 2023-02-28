<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
if(isset($_GET['id']) && isset($_POST['offer_price']) && isset($_POST['offer_source']) && isset($_POST['offer_id'])) {
    // If form sent data, add new buy offer
    $mysqli->query("INSERT INTO offer(card_id, source, source_id, price) VALUES (".$_GET['id'].", '".$_POST['offer_source']."', ".$_POST['offer_id'].", ".$_POST['offer_price'].")");
    if($mysqli->errno) {
        echo '<p>Error: offer hasn\'t been added (' . $mysqli->errno . ') ' . $mysqli->error . '</p>';
        echo '<p><a href="cards_list_offer.php?id='.$_GET['id'].'">&#9668; Buy offers list</a></p>';
    } else {
        header('Location: cards_list_offer.php?id='.$_GET['id'].'&action=offer_added');
        exit();
    }
} elseif(isset($_GET['id'])) {
    // If form didn't send data of new buy offer, display form
    echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; <a href="cards_list_offer.php?id='.$_GET['id'].'">Edit GPU buy offers</a> &#9658; Add new buy offer</h1>';
    echo '<hr />';	
    // Display GPU Name
    $card = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
    $row = mysqli_fetch_row($card);
    echo '<p><b>'.$row[1].'</b></p>';		
    // Form
    echo '<form name="addNewOffer" method="POST" action="cards_list_offer_add.php?id='.$_GET['id'].'" onsubmit="return validateAddNewOfferForm()">
    <p>Price ('.$GLOBALS['currency_symbol'].'): <input name="offer_price" type="number" /> Source:
    <select name="offer_source"><option value=""></option>';
    $offer_sources = explode(',', $GLOBALS['offer_sources']);
    $offer_sources_lenght = count($offer_sources);
    for($i=0; $i<$offer_sources_lenght; $i++) {
        echo '<option value="'.$offer_sources[$i].'">'.$offer_sources[$i].'</option>';
    }	
    echo '</select>
    External offer ID: <input name="offer_id" type="number" /> <input type="submit" value="Add" /></p>
    </p></form>';
}
include 'inc/footer.php';