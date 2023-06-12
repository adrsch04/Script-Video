<style>
  /* Simples Styling für die Card und den Container */
  .card {
    box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.2);
    border-radius: 0.5rem;
    padding: 1rem 2rem;
  }

  .container {
    font-family: Arial, Helvetica, sans-serif;
    padding: 1rem;
  }

  img {
    width: 10%;
    height: auto;
    margin-right: 1rem;
    border-radius: 0.5rem;

  }

  .flex {
    display: flex;
    flex-direction: row;
  }
</style>

<?php
require 'vendor/autoload.php';
error_reporting(E_ALL ^ E_DEPRECATED);

use jcobhams\NewsApi\NewsApi;

$api_key = "068bc1b002574cf2aa1eb521cdbcd25a";

$newsapi = new NewsApi($api_key);

// parameter setzten
$q = "games";
$from = "2023-06-09";
$to = "2023-06-11";
$language = "en";
$sort_by = "popularity";

// API call mit query Parametern machen
$response = $newsapi->getEverything($q, null, null, null, $from, $to, $language, $sort_by,  null, null);

// Überprüfen ob der API call erfolgreich war
if ($response !== false) {
  // Die JSON response dekodieren
  $data = json_decode(json_encode($response), true);

  // Check ob die JSON dekodierung erfolgreich war
  if ($data !== null && isset($data['articles'])) {
    echo ("<div class='card'><div class='container'>");
    echo "Anzahl Resultate: " . $data['totalResults'];
    echo "</div></div>";
    // Über die Artikel iterieren
    foreach ($data['articles'] as $article) {
      // Artikel Titel, Beschreibung und URL anzeigen.
      echo "<div class='container flex'>";
      echo "<img src=" . $article["urlToImage"] . " alt='Article Image'>";
      echo ("<div class='card'>");
      echo '<p style="">Titel: ' . $article['title'] . '</p>';
      echo '<p>Beschreibung: ' . $article['description'] . '<p>';
      echo '<a href="' . $article['url'] . '">URL: ' . $article['title'] . '</a>';
      echo "</div></div>";
    }
  } else {
    // Fehlermeldung falls der API
    echo 'Error: Fehlerhafte API response.';
  }
} else {
  // Fehlermeldung falls der API call fehlschlägt
  echo 'Error: API daten konnten nicht abgefragt werden.';
}
