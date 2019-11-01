<?php
require_once("./databaseManager/DBEnter.db.php");
session_start();
$username = $_SESSION['username'];

$account = DB::queryFirstRow("SELECT * FROM votedAccounts WHERE votedAccounts=%s", $username);

if (DB::affectedRows() != 0) {
  echo "Already Voted";
  exit;
}

$k = 1;
for ($k = 1; $k <= 10; $k++) {
  if (!isset($_POST[$k.'']) || !is_numeric($_POST[$k.''])) continue;
  $votes = 11-$k;
  $sid = $_POST[$k.''];
  DB::insert("votedAccounts", array(
      'VID' => intval($sid),
      'votes' => $votes,
      'votedStudent' => $username
  ));
  file_put_contents("../vote_log_2019.txt", "$sid, $votes, $username;".PHP_EOL , FILE_APPEND | LOCK_EX);
}

echo "Success";
?>