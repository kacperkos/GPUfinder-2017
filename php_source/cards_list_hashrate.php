<?php
include 'inc/config.php';
include 'inc/dbconnect.php';
include 'inc/functions.php';
include 'inc/header.php';
// If new Hashrate has been added, show message
if(isset($_GET['action']) && $_GET['action'] == 'hashrate_added') {
    echo '<script>alert("Information: New GPU Hashrate has been added");</script>';
}
// If Hashrate has been edited, show message
if(isset($_GET['action']) && $_GET['action'] == 'hashrate_edited') {
    echo '<script>alert("Information: GPU Hashrate has been updated");</script>';
}
// If Hashrate has been deleted, show message
if(isset($_GET['action']) && $_GET['action'] == 'hashrate_deleted') {
    echo '<script>alert("Information: GPU Hashrate has been deleted");</script>';
}
echo '<h1><a href="index.php"><b>GPU</b>finder</a> &#9658; <a href="cards_list.php">GPUs list</a> &#9658; Edit GPU Hashrate</h1>';
echo '<hr />';
echo '<p><a href="cards_list_hashrate_add.php?id='.$_GET['id'].'" >&#9658; Add new GPU Hashrate</a></p>';
echo '<hr />';
// Display GPU Name
$card = $mysqli->query("SELECT * FROM card WHERE id = ".$_GET['id']."");
$row = mysqli_fetch_row($card);
echo '<p><b>'.$row[1].'</b></p>';
// Display GPUs' Hashrates list
$hashrates = $mysqli->query("SELECT * FROM hashrate WHERE card_id = ".$_GET['id']." ORDER BY crypto_id, hashrate ASC");
echo '<table>
<tr class="firstTR">
    <td>Hashrate ID</td>
    <td>Cryptocurrency</td>
    <td>Hashrate</td>
    <td>Actions</td>
</tr>';
while($hashrate = mysqli_fetch_row($hashrates)) {
    echo '<tr>
    <td>'.$hashrate[0].'&nbsp;&nbsp;&nbsp;</td>';
    $cryptos = $mysqli->query("SELECT * FROM crypto WHERE id = ".$hashrate[2]." LIMIT 1");
    $crypto = mysqli_fetch_array($cryptos);
    echo '<td>'.$crypto[1].' ('.$crypto[2].')&nbsp;&nbsp;&nbsp;</td>
    <td>'.$hashrate[3].'&nbsp;&nbsp;&nbsp;</td>
    <td><a href="cards_list_hashrate_update.php?id='.$_GET['id'].'&hashrate_id='.$hashrate[0].'">[edit]</a><a href="cards_list_hashrate_delete.php?id='.$_GET['id'].'&hashrate_id='.$hashrate[0].'&confirmation=no">[delete]</a>&nbsp;&nbsp;&nbsp;</td>
    </tr>';
}
echo '</table>
<hr />
<p>Information: You can add many hashrates for single GPU, if you for example have different data from different sources (average Hashrate will be calculated).</p>';
include 'inc/footer.php';