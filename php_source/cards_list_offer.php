<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
// If new buy offer has been added, display message
if(isset($_GET['action']) && $_GET['action'] == 'offer_added') {
    echo '<script>alert("Information: New GPU buy offer has been added");</script>';
}
// If offer has been edited, display message
if(isset($_GET['action']) && $_GET['action'] == 'offer_edited') {
    echo '<script>alert("Information: Offer has been updated");</script>';
}
// If offer has been delated, display message
if(isset($_GET['action']) && $_GET['action'] == 'offer_deleted') {
    echo '<script>alert("Information: Offer has been deleted");</script>';
}
echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; Edit GPU buy offers</h1>';
echo '<hr />';
echo '<p><a href="cards_list_offer_add.php?id='.$_GET['id'].'" >&#9658; Add new buy offer </a></p>';
echo '<hr />';
// Display GPU Name
$card = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
$row = mysqli_fetch_row($card);
echo '<p><b>'.$row[1].'</b></p>';
// Display GPUs buy offers list
$offers = $mysqli->query("SELECT * FROM offer WHERE card_id = ".$_GET['id']." ORDER BY price ASC");
echo '<table>
<tr class="firstTR">
    <td>Offer ID</td>
    <td>Price</td>
    <td>Source</td>
    <td>External offer ID</td>
    <td>Action</td>
</tr>';
while($offer = mysqli_fetch_row($offers)) {
    echo '<tr>
    <td>'.$offer[0].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$offer[4].' '.$GLOBALS['currency_symbol'].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$offer[2].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$offer[3].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.getOfferLink($offer[3], $offer[2]).'<a href="cards_list_offer_update.php?id='.$_GET['id'].'&offer_id='.$offer[0].'">[edit]</a><a href="cards_list_offer_delete.php?id='.$_GET['id'].'&offer_id='.$offer[0].'&confirmation=no">[delete]</a>&nbsp;&nbsp;&nbsp;</td>
    </tr>';
}
echo '</table>';
include 'inc/footer.php';