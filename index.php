<?php
    require_once "include/http/query.inc.php";

    define("API_KEY","35ef7996395d4c2bb1cedbbd47ecf1a0");

    define("ITEM_TYPE_WEAPON", 1);
    define("ITEM_TYPE_KINETICWEAPON", 2);
    define("ITEM_TYPE_ENERGYWEAPON", 3);
    define("ITEM_TYPE_POWERWEAPON", 4);
    define("ITEM_TYPE_ARMOR", 30);
    define("ITEM_TYPE_HELMETS", 45);
    define("ITEM_TYPE_ARMS", 46);
    define("ITEM_TYPE_CHEST", 47);
    define("ITEM_TYPE_LEGS", 48);
    define("ITEM_TYPE_CLASSITEMS", 49);

    define("ITEM_SLOT_FILTER", array(
      ITEM_TYPE_KINETICWEAPON,
      ITEM_TYPE_ENERGYWEAPON,
      ITEM_TYPE_POWERWEAPON,
      ITEM_TYPE_HELMETS,
      ITEM_TYPE_ARMS,
      ITEM_TYPE_CHEST,
      ITEM_TYPE_LEGS,
      ITEM_TYPE_CLASSITEMS
    ));

    define("ITEM_TIER_COMMON", 3340296461);
    define("ITEM_TIER_UNCOMMON", 2395677314);
    define("ITEM_TIER_RARE", 2127292149);
    define("ITEM_TIER_LEGENDARY", 4008398120);
    define("ITEM_TIER_EXOTIC", 2759499571);

    define("ITEM_TIER_TYPES", array(
      ITEM_TIER_COMMON,
      ITEM_TIER_UNCOMMON,
      ITEM_TIER_RARE,
      ITEM_TIER_LEGENDARY,
      ITEM_TIER_EXOTIC,
    ));

    define("ITEM_STAT_RPM", 4284893193);

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


    /*$http = new http\Query();
    
    $http->setOption(CURLOPT_URL, $apiRoot.'/Destiny2/Manifest/');
    $http->setOption(CURLOPT_RETURNTRANSFER, 1);
    $http->setOption(CURLOPT_SSL_VERIFYHOST, 0);
    $http->setOption(CURLOPT_SSL_VERIFYPEER, 0);
    $http->setOption(CURLOPT_HTTPHEADER, array('X-API-Key: ' .API_KEY));

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
    $items = $pdo->query("SELECT * FROM DestinyInventoryItemDefinition")->fetchAll();
    $itemQualities = $pdo->query("SELECT * FROM DestinyItemTierTypeDefinition")->fetchAll();
    $itemStats = $pdo->query("SELECT * FROM DestinyStatDefinition")->fetchAll();
    $itemTypes = $pdo->query("SELECT * FROM DestinyItemCategoryDefinition")->fetchAll();
    $characterClasses = $pdo->query("SELECT * FROM DestinyClassDefinition")->fetchAll();

    // Item Filter
    $itemFilter = array(2,3,4,38,39,40,41,42);
?>
  <!DOCTYPE html>
  <html>

  <head>
    <link rel="stylesheet" href="css/bootstrap-4.0.0-beta.2/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
      crossorigin="anonymous"></script>
    <script src="js/jquery-3.2.1/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-4.0.0-beta.2/bootstrap.min.js"></script>
    <title>Destiny 2 Arsenal</title>
    <style>
       :root {
        --item-colour-common: rgb(195, 188, 180);
        --item-colour-uncommon: rgb(54, 111, 66);
        --item-colour-rare: rgb(80, 118, 163);
        --item-colour-legendary: rgb(82, 47, 101);
        --item-colour-exotic: rgb(206, 174, 51);
      }

      body {
        font-family: Roboto, sans-serif;
      }

      #item-table td {
        vertical-align: middle;
        font-size: 13px;
      }

      .breadcrumb {
        margin-bottom: 0;
        padding: 10px;
      }
    </style>
  </head>

  <body class="bg-secondary">
    <div class="jumbotron rounded-0">
      <h1>Destiny Arsenal</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Arsenal</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#">Database
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
      <ol class="breadcrumb" style="background-color: inherit;">
        <li class="breadcrumb-item">
          <a class="text-white" href="#">Database</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Items</li>
      </ol>
      <div class="container table-dark">
        <h2>Items</h2>
        <a data-toggle="collapse" href="#search-form" aria-expanded="false" aria-controls="search-form">Filter...</a>
        <div id="search-form" class="collapse">
          <form action="index.php" method="POST">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="input-search-item">Name:</label>
                  <input id="input-search-item" class="form-control form-control-sm rounded-0" type="text" placeholder="Item Name">
                </div>
                <div class="form-group">
                  <label for="select-item-class">Used by:</label>
                  <select id="select-item-class" class="form-control form-control-sm rounded-0">
                    <?php foreach($characterClasses as $class): ?>
                    <option>
                      <?php echo json_decode($class['json'])->displayProperties->name;  ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="select-item-slot">Slot:</label>
                  <select id="select-item-slot" size="5" multiple class="form-control rounded-0">
                    <?php for($i = 0; $i < sizeof($itemTypes); $i++): ?>
                    <?php for($j = 0; $j < sizeof(ITEM_SLOT_FILTER); $j++): ?>
                    <?php if(ITEM_SLOT_FILTER[$j] == json_decode($itemTypes[$i]['json'])->hash): ?>
                    <option>
                      <?php echo json_decode($itemTypes[$i]['json'])->displayProperties->name ?>
                    </option>
                    <?php endif ?>
                    <?php endfor ?>
                    <?php endfor ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="select-item-qualities">Quality:</label>
                  <select id="select-item-qualities" size="5" multiple class="form-control rounded-0">
                    <?php for($i = 0; $i < sizeof($itemQualities); $i++): ?>
                    <?php for($j = 0; $j < sizeof(ITEM_TIER_TYPES); $j++): ?>
                    <?php if(ITEM_TIER_TYPES[$j] == json_decode($itemQualities[$i]['json'])->hash): ?>
                    <option style="color: var(--item-colour-<?php echo strtolower(json_decode($itemQualities[$i]['json'])->displayProperties->name) ?>);">
                      <?php echo json_decode($itemQualities[$i]['json'])->displayProperties->name ?>
                    </option>
                    <?php endif ?>
                    <?php endfor ?>
                    <?php endfor ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <button class="btn btn-primary rounded-0" type="submit">Filter</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <table id="item-table" class="table table-dark table-hover">
        <thead>
          <tr>
            <!--<th scope="col"></th>-->
            <th scope="col" colspan="2">Name</th>
            <th scope="col">RPM</th>
            <th scope="col">Slot</th>
            <th scope="col">Type</th>
            <th scope="col">Sub Type</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($items as $item): ?>
          <?php $item = json_decode($item['json'], false, 512) ?>
          <?php if(isset($item->itemCategoryHashes)/* && in_array(ITEM_TYPE_KINETICWEAPON, $item->itemCategoryHashes)*/): ?>
          <?php foreach(ITEM_SLOT_FILTER as $slot): ?>
          <?php if(in_array($slot, $item->itemCategoryHashes)): ?>
          <tr>
            <td style="padding-right: 0px;width: 62px">
              <img class="img-thumbnail" style="width: inherit" src="<?php echo $dbRoot.$item->displayProperties->icon ?>" alt="Generic placeholder image">
            </td>
            <td style="padding-left: 6px; color: var(--item-colour-<?php echo strtolower($item->inventory->tierTypeName) ?>);">
              <?php echo $item->displayProperties->name ?>
              <?php //echo $item->displayProperties->description ?>
            </td>
            <td>
              <?php foreach($item->stats->stats as $stats): ?>
              <?php if($stats->statHash === ITEM_STAT_RPM): ?>
              <?php echo $stats->value ?>
              <?php endif ?>
              <?php endforeach ?>
            </td>
            <td>
              <?php
                if(isset($item->itemCategoryHashes[0])) {
                  $slotID = $item->itemCategoryHashes[0]-1; 
                  $slot = json_decode($itemTypes[$slotID]['json'])->displayProperties->name;
                  echo $slot;
                } else {
                  echo "-";
                }
              ?>
            </td>
            <td>
              <?php if(isset($item->itemCategoryHashes[2])): ?>
              <?php $slotID = $item->itemCategoryHashes[2]-1; ?>
              <?php $slot = json_decode($itemTypes[$slotID]['json'])->displayProperties->name; ?>
              <?php echo $slot; ?>
              <?php else: ?>
              <?php echo "-"; ?>
              <?php endif ?>
            </td>
            <td>
              <?php
                if(isset($item->itemCategoryHashes[1])) {
                  $slotID = $item->itemCategoryHashes[1]-1; 
                  $slot = json_decode($itemTypes[$slotID]['json'])->displayProperties->name;
                  echo $slot;
                } else {
                  echo "-";
                }
              ?>
            </td>
          </tr>
          <?php endif ?>
          <?php endforeach ?>
          <?php endif ?>
          <?php endforeach ?>
        </tbody>
      </table>
      <div class="container table-dark">
        <nav aria-label="Page navigation example">
          <ul class="pagination paginations-sm justify-content-end">
            <li class="page-item disabled bg-dark">
              <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </body>

  </html>