<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$file = '../leaderboard.txt';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($file)) {
        echo file_get_contents($file);
    } else {
        echo '[]';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $leaderboard = json_decode(file_get_contents($file) ?: '[]', true);
    
    $leaderboard[] = $input;
    usort($leaderboard, function($a, $b) { return $b['score'] - $a['score']; });
    $leaderboard = array_slice($leaderboard, 0, 10);
    
    file_put_contents($file, json_encode($leaderboard));
    echo json_encode($leaderboard);
}
?>