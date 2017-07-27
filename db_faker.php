<?php
/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license LTM
 */
require __DIR__."/crayner_utl.php";
$start = microtime(true);
$q = "-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `token` varchar(500) NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2017-07-27 13:22:12
";

foreach (explode("\n", $q) as $val) {
	!isset($qp) and $qp = "";
	if (substr($val, -1, 1) == ";") {
		$st = pdo()->prepare($qp.$val)->execute();
		$qp = null;
		var_dump($st);
	} else {
		$qp .= $val;
	}
}

$st = pdo()->prepare("INSERT INTO `test` (`token`, `userid`, `created_at`) VALUES (:token, :userid, :now);");
for ($i=0; $i < 100; $i++) {
	$data = [
			":token" => rstr(500),
			":userid" => $i,
			":now" => time()
		];
	echo $i."\t|\t".json_encode($data)." ";
	var_dump(
		$st->execute($data)
	);
}
echo "\n\n".(microtime(true)-$start)."\n\n";