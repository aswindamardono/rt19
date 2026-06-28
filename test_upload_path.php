<?php
$path1 = './assets/img/inventaris/';
$path2 = __DIR__ . '/assets/img/inventaris/';

echo "Path 1 (./assets/img/inventaris/):\n";
echo "is_dir: " . (is_dir($path1) ? 'Yes' : 'No') . "\n";
echo "is_writable: " . (is_writable($path1) ? 'Yes' : 'No') . "\n";
echo "realpath: " . realpath($path1) . "\n\n";

echo "Path 2 (__DIR__ . /assets/img/inventaris/):\n";
echo "is_dir: " . (is_dir($path2) ? 'Yes' : 'No') . "\n";
echo "is_writable: " . (is_writable($path2) ? 'Yes' : 'No') . "\n";
echo "realpath: " . realpath($path2) . "\n\n";
