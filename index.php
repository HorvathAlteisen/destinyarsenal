<?php
    require_once "include/http/query.inc.php";

    // Bungie API-Key
    $apiKey = "35ef7996395d4c2bb1cedbbd47ecf1a0";
    $apiRoot = "https://www.bungie.net/Platform";
    $dbRoot = "https://www.bungie.net";

    $languages = array('en'     => 'English',
    'fr'    => 'Français',
    'es'    => 'Español',
    'de'    => 'Deutsch',
    'it'    => 'Italiano',
    'ja'    => '日本語', // Japanese
    'pt-br' => 'Português (Brasileiro)',
    'es-mx' => 'Spanish Mexico',
    'ru'    => 'Русский', // Russian
    'pl'    => 'Polski',
    'zh-cht'=> '繁体字', // Chinese Traditional
    );


    $http = new http\Query();
    /*
    {
    "access_token": "CN8rEoYCACDQC+bEFlI5c9jL2iEDp857WqYRCh5o/CVuNVNxYqwdu+AAAAAA1Kpe9ioJ3v/L1j5zLovOCg2Rdrg97OBvja/knibVRxIaDi59pZ4MwpY+WdeKRuWuKiIG7KBDSzzjhSF0ltNr+bTSXNnVYKX3f7Uulz9CmXsvdv0PEcyhqO3wZFgcbbAwQZ22jM1XvGSPpu432bOPJYdNN7tsVPVYcCb7m5SmGs66RtwbZJp69HxBgaoMgHvZnU3Y0E4lcFZE4k8ItSslDm0SUscjzMkZtq/WAhmW02nzPRiUfs6TqV4o5MdeywOtbxbCsdbqP9E5PZ0H13CaWUbSaHfmAKVeqkjStiuXNA==",
    "token_type": "Bearer",
    "expires_in": 3600,
    "refresh_token": "CN8rEoYCACD0bXfPF6sD8FaZ90QUqW4M3vJpMoBtc+ODdgErlLCN2+AAAAAUqmzgUNIDgB0N3nU4VaU4bRkM7JBJFYSUlrahhTsjcuJprHMVWpsQix4Euu6L7+y+H9OhlJOrPfrrwvfd5E0Zpb3/xxYhEScuckJ6AQUB15OsZzY/ZCpRxCxRSsGxugraXwkFe+uspLfL+t4HTnbIgw5E02lF6nLdlBrtwMMA4aScd97tw1hh9pxSGJ9JzSx3xC+c0oN88ndyIuxrySQ46taIzSG3vI4L7531V7bjc+F8nhPebevnMs/nU3sEJC46hsfryzhgebAyICUDUzfonjWUQb6gDM7tVtI/bPCdpQ==",
    "refresh_expires_in": 7776000,
    "membership_id": "17019987"
}
    $http->setOption(CURLOPT_URL, $apiRoot.'/Destiny2/Manifest/');
    $http->setOption(CURLOPT_RETURNTRANSFER, 1);
    $http->setOption(CURLOPT_SSL_VERIFYHOST, 0);
    $http->setOption(CURLOPT_SSL_VERIFYPEER, 0);
    $http->setOption(CURLOPT_HTTPHEADER, array('X-API-Key: ' .$apiKey));

    $json = json_decode($http->execute());
    $http->close();

    /*$sqliteDBPath = new http\Query();
    $sqliteDBPath->setOption(CURLOPT_URL, $dbRoot.$json->Response->mobileWorldContentPaths->en);
    $sqliteDBPath->setOption(CURLOPT_RETURNTRANSFER, 1);
    $sqliteDBPath->setOption(CURLOPT_SSL_VERIFYHOST, 0);
    $sqliteDBPath->setOption(CURLOPT_SSL_VERIFYPEER, 0);
    $sqliteDB = $sqliteDBPath->execute();

    fopen('db/en/world_sql_content.db', 'W+', $sqliteDB);*/

    $pdo = new PDO('sqlite:db/en/world_sql_content.content');

    //echo $pdo->query("SELECT name FROM sqlite_master WHERE type=\'table\';");
    $stmt = $pdo->query("SELECT * FROM DestinyInventoryItemDefinition");

    $items = $stmt->fetchAll();
    //echo var_dump($json->Response->mobileWorldContentPaths);


?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/bootstrap-4.0.0-beta.2/bootstrap.min.css">
    <script href="js/bootstrap-4.0.0-beta.2/bootstrap.min.js"></script>
    <title>Destiny 2 Arsenal</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Arsenal</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Items <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
  </div>
</nav>
    <div class="container bg-dark">
   	<?php foreach($items as $item): ?>
    <?php $json = json_decode($item['json']);?>
          <div class="media">
            <img class="align-self-start mr-3" src="<?php echo $dbRoot.$json->displayProperties->icon ?>" alt="Generic placeholder image">
            <div class="media-body">
              <h5 class="mt-0">Description</h5>
              <p><?php echo $json->displayProperties->description ?></p>
            </div>
          </div>
    <?php endforeach ?>
    </div>
</body>

</html>
