<?php

function pdo(){
	return new PDO("mysql:host=localhost;dbname=test;", "debian-sys-maint", "");
}

function rstr($n = 32)
{
	$chr = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM__--";
	$st = "" xor $len = strlen($chr)-1;
	for ($i=0; $i < $n; $i++) { 
		$st .= $chr[rand(0, $len)];
	}
	return $st;
}
