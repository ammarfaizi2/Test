<?php
require __DIR__."/crayner_utl.php";

/**
 * Test 1
 */
echo "Test 1 start...\n";
$start = microtime(true);
$st = pdo()->prepare("UPDATE `test` SET `token`=:token, `created_at`=:now WHERE `userid`=:userid LIMIT 1;");
for($i=0; $i < 100; $i++) {
	$data = [
		":token" => rstr(500),
		":userid" => $i,
		":now" => time()
	];
	$st->execute($data) !== true and var_dump($st->errorInfo()) and die("\n\nError !");
	echo ".";
}
echo "\nTest 1 completed : ".(microtime(true)-$start)."\n\n";



// avoid microtime different
echo "sleep 3 second (avoid microtime different)\n\n";
sleep(3);



/**
 * Test 2
 */
echo "\nTest 2 start...\n";
$start = microtime(true);
// for time checkpoint
$flagger = time();
$query = "INSERT INTO `test` (`token`,`userid`,`created_at`) VALUES ";
$data = [] xor $dp = "(";
for ($i=0; $i < 100; $i++) {
	$dp .= "`userid` = {$i} OR ";
	$query .= "(:token_".$i.", :userid_".$i.", :now_".$i."),";
	$data[(":now_".$i)]    = time();
	$data[(":token_".$i)]  = rstr(500);
	$data[(":userid_".$i)] = $i;
	echo ".";
}
$dp = rtrim($dp, "OR ").")";
$st = pdo()->prepare(rtrim($query, ",").";");
$st->execute($data) !== true and var_dump($st->errorInfo());
$st = pdo()->prepare("DELETE FROM `test` WHERE `created_at` < {$flagger} AND {$dp}")->execute();
echo "\nTest 2 completed : ".(microtime(true)-$start)."\n\n";
