<?php

global $modx;

/** @var int $page_id | ModX уникальный id ресурса */
$page_id = $modx->documentIdentifier;

$request = $modx->db->query("SELECT `content` FROM `modx_site_content` WHERE `id` = " . $page_id);
$response = $modx->db->getRow($request);

/** @var string $content | ModX контент HTML редактора ресурса */
$content = $response['content'];

if (!isset($_SESSION['webinars'])) {
    $_SESSION['webinars'] = array();
}

if (!in_array($page_id, $_SESSION['webinars'])) {
    $_SESSION['webinars'] += array($page_id => uniqid());
}

/** @var string $boundary | Создание уникального ключа для пользователя */
$boundary = $_SESSION['webinars'][$page_id];

/** @var  $data | Сбор параметров для создания формы */
$data = array(
    'page_id' => $page_id,
    'boundary' => $boundary,
    'content'  => base64_encode($content),
    'roistat_id' => 'test',
    'visitor_info' => 'test',
    'fingerprint' => 'test',
    'yan_uid' => 'test',
    'uip' => 'test',
);

/** @var  $ch | Запрос создания шаблона.
 * При использовании cURL HTTP CLIENT фреймворка Symfony считает, что передаётся raw data
 */
$ch = curl_init('https://example.com/api/webinar/feedback/create/sample');

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_exec($ch);
curl_close($ch);

?>

<!-- Загрузка формы для пользователя -->
<iframe frameborder="0" width="600" height="0" id="feedbackFrame" name="feedbackFrame" src="https://example.com/webinar/feedback/form/<?= $boundary; ?>">
    Your browser does not support inline frames.
</iframe>

<script>
    let getMeTo = document.getElementById("feedbackFrame");
    getMeTo.scrollIntoView({behavior: 'smooth'}, true);

    if (window.addEventListener) {
        window.addEventListener("message", onMessage, false);
    } else if (window.attachEvent) {
        window.attachEvent("onmessage", onMessage, false);
    }

    function onMessage(event) {
        // Check sender origin to be trusted
        if (event.origin !== "https://example.com") return;

        var data = event.data;

        if (typeof(window[data.func]) == "function") {
            window[data.func].call(null, data.message);
        }
    }

    // Function to be called from iframe
    function setFrameHeight(message) {
        let params = message.split('&');

        let feedbackFrame = document.getElementsByName('feedbackFrame')[0];
        let height = params[0].split('=')[1];

        setTimeout(() => {
            feedbackFrame.style.height = height + 'px';
        }, height - 10);

        feedbackFrame.animate(
            { height: height + 'px' },
            height
        );
    }
</script>