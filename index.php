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
    $stmt = $pdo->query("SELECT * FROM DestinyInventoryItemDefinition");
    $items = $stmt->fetchAll();
    //echo var_dump($json->Response->mobileWorldContentPaths);

    // Item Filter
    $itemFilter = array(2,3,4,38,39,40,41,42);
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/bootstrap-4.0.0-beta.2/bootstrap.min.css">
    <script href="js/bootstrap-4.0.0-beta.2/bootstrap.min.js"></script>
    <title>Destiny 2 Arsenal</title>
  </head>
  <body class="bg-dark">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Arsenal</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#">Items
              <span class="sr-only">(current)</span>
            </a>
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
    <div class="container">
      <div class="container">
        <a href="#">filter</a>
      </div>
      <table class="table table-dark table-hover">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($items as $item): ?>
          <?php $json = json_decode($item['json'], false, 512) ?>
          <?php if(isset($json->itemCategoryHashes) && in_array(2, $json->itemCategoryHashes)): ?>
          <tr>
            <td>
              <img class="img-thumbnail" src="<?php echo $dbRoot.$json->displayProperties->icon ?>" alt="Generic placeholder image">              
            </td>
            <td>
              <h5 class=""><?php echo $json->displayProperties->name ?></h5>
              <blockquote cite="">
                <?php echo $json->displayProperties->description?>
              </blockquote>
            </td>
            <td>
              <span>
                <?php foreach($json->itemCategoryHashes as $type): ?>
                <?php echo $type ?>
                <?php endforeach ?>
              </span>
            </td>
          </tr>
          <?php endif ?>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </body>

  </html>