<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/model/Link.php';


$modelLink = new Link();
$linkId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$link = $modelLink->getLinkById($linkId);
if(!$link) {
    http_response_code(404);
    echo "Link não encontrado";
    return;
}
$ip_address = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['
'] : 'Direto';

$returnRegister = $modelLink->registerClick($linkId, $ip_address, $browser, $referer);
if(!$returnRegister) {
    http_response_code(500);
    echo "Erro ao registrar o clique no link";
    return;
}
header('Location: ' . $link['url_link']);
exit;

?>