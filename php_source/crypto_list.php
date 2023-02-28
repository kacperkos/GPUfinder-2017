<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; Cryptocurrencies list</h1>';
echo '<hr />';
echo '<p><a href="crypto_list_add.php">Add new cryptocurrency</a></p>';
echo '<hr />';
// If new cryptocurrency has been added, display message
if(isset($_GET['action']) && $_GET['action'] == 'crypto_added') {
    echo '<script>alert("Information: New cryptocurrenct has been added");</script>';
}
// If cryptocurrency has been updated, display message
if(isset($_GET['action']) && $_GET['action'] == 'crypto_edited') {
    echo '<script>alert("Information: Cryptocurrency has been updated");</script>';
}
// If cryptocurrency has been deleted, display message
if(isset($_GET['action']) && $_GET['action'] == 'crypto_deleted') {
    echo '<script>alert("Information: Cryptocurrency has been deleted");</script>';
}
// Display GPUs list
$cryptos = $mysqli->query("SELECT * FROM crypto ORDER BY name ASC");
echo '<table>
<tr class="firstTR">
    <td>Cryptocurrency ID</td>
    <td>Symbol</td>
    <td>Name</td>
    <td>Price</td>
    <td>Extraction per hour at 10 Mh/s</td>
    <td>Action</td>
</tr>';
while($crypto = mysqli_fetch_row($cryptos)) {
    echo '<tr>
    <td>'.$crypto[0].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$crypto[2].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$crypto[1].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$crypto[3].' '.$GLOBALS['currency_symbol'].'&nbsp;&nbsp;&nbsp;</td>
    <td>'.$crypto[4].'&nbsp;&nbsp;&nbsp;</td>
    <td><a href="crypto_list_update.php?crypto_id='.$crypto[0].'">[edytuj]</a>';
    // If specific cryptocurrency hasn't any Hashrates, display delete action
    $hashrates = $mysqli->query("SELECT * FROM hashrate WHERE crypto_id = ".$crypto[0]."");
    $hashrate = mysqli_fetch_array($hashrates);
    if($hashrate == NULL) {
        echo '<a href="crypto_list_delete.php?crypto_id='.$crypto[0].'&confirmation=no">[delete]</a>';
    }
    echo '</td>
    </tr>';
}
echo '</table>
<hr />
<p>Information: Cryptocurrency can be deleted only if any GPU hasn\'t Hashrates for this cryptocurrency</p>';
include 'inc/footer.php';