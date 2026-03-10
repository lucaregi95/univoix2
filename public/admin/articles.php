<?php
function loadRss($url) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ignore le certificat SSL
    $data = curl_exec($ch);
    curl_close($ch);

    return simplexml_load_string($data);
}

// Cette fonction peut retourner tous les articles de plusieurs flux
function getArticles() {
    $feeds = [
        "https://www.lemonde.fr/rss/une.xml"
    ];

    $articles = [];

    foreach ($feeds as $feed) {
        $rss = loadRss($feed);
        if ($rss) {
            foreach ($rss->channel->item as $item) {
                $articles[] = [
                    "title" => (string)$item->title,
                    "link" => (string)$item->link,
                    "description" => (string)$item->description,
                    "date" => (string)$item->pubDate
                ];
            }
        }
    }

    return $articles;
}
?>
<?php


$articles = getArticles();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Articles RSS</title>
    <a href="../../style/style_admin/articles.css" rel="stylesheet">
</head>
<body>

<h1>Articles récents</h1>

<?php foreach ($articles as $article) { ?>
    <div>
        <h2><a href="<?php echo $article["link"]; ?>" target="_blank"><?php echo $article["title"]; ?></a></h2>
        <p><?php echo $article["description"]; ?></p>
        <small><?php echo $article["date"]; ?></small>
    </div>
<?php } ?>

</body>
</html>

