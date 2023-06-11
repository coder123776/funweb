<?php
session_start();
$_SESSION['filetype'] = 2;
$_SESSION['WebAllowed'] = true;
$_SESSION['headerColor'] = "black";
include_once("../../includes/classes/database.php");
include_once("../../includes/functions/functions.php");
include_once("../../includes/controllers/UserController.php");
include_once("../../includes/classes/UserClasses.php");
include_once("../../includes/classes/ProductClasses.php");
include_once("../../includes/classes/FriendsClasses.php");
include_once("../../includes/defaults/header.php");

if (!isset($_SESSION['userid'])){
  header("location: ../../users/start/login.php");
}
if (isset($_POST['product'])){
  $productId = $_POST['productId'];
  $_SESSION['productId'] = $_POST['productId'];
}
if (! $_SESSION['productId']){
  header("location: ../../web/main/index.php");
}
if (isset($_SESSION['productId'])){
  $productId = $_SESSION['productId'];
}

$productManager = new Products();
$productName = $productManager->getproduct($productId, "name");
$productValue = $productManager->getproduct($productId, "value");
$productDiscription = $productManager->getproduct($productId, "description");
$productImage = $productManager->getproduct($productId, "image");
$productCompany = $productManager->getproduct($productId, "company");
$productTags = $productManager->getproduct($productId, "tags");
$productLimiteds = $productManager->getproduct($productId, "limiteds");
$productCreator = $productManager->getproduct($productId, "creator");
$productMedal = $productManager->getproduct($productId, "medal");
$productStartdate = $productManager->getproduct($productId, "startdate");
$productOwners = $productManager->getproduct($productId, "owners");
$productViews = $productManager->getproduct($productId, "views");
$productFavorites = $productManager->getproduct($productId, "favorites");
$productLikes = $productManager->getproduct($productId, "likes");
$productDislikes = $productManager->getproduct($productId, "dislikes");
$productHistoryprices = $productManager->getproduct($productId, "historyprices");
$productSponsor = $productManager->getproduct($productId, "sponsor");

if (isset($_POST['sellItem'])) {
      $serialId = $_POST['serialId'];
      $productId = $_POST['productId'];
      $userid = $_POST['userid'];
      if (validateToken("serialId", $serialId) && validateToken("productId", $productId) && validateToken("userid", $userid)) {
          // token is geldig
          sellingScreen($userid, $user->getUsername(), $productId, $productName, $productDiscription, $serialId, $user->getPicture());
      } else {
          // GEBRUIKER VALT AAN! DUS BAN HEM
      }
      $_SESSION['validate'] = true;
}
if (isset($_POST['sellConformation'])) {
    $userid = $_POST['SELLuserId'];
    $username = $_POST['SELLusername'];
    $itemid = $_POST['SELLitemid'];
    $serialId = $_POST['SELLserial'];
    $userimage = $_POST['SELLimage'];
    $itemvalue = $_POST['itemValue'];

    if (validateToken("SELLuserId", $userid) && validateToken("SELLusername", $username) && validateToken("SELLitemid", $itemid)
    && validateToken("SELLserial", $serialId) && validateToken("SELLimage", $userimage)) {
        // token is geldig
        $productManager->resel($userid, $username, $itemid, $serialId, $itemvalue, $userimage);
    } else {
        // GEBRUIKER VALT AAN! DUS BAN HEM
    }
    unset($_POST['sellConformation']);
}
if (isset($_POST['cancelItem'])){
    $serialId = $_POST['serialId'];
    if (!isset($_POST['sellerId'])){
      $sellerId = $userid;
    }else{
      $sellerId = $_POST['sellerId'];
    }

    if (validateToken("serialId", $serialId) && validateToken("sellerId", $sellerId)) {
        $productManager->cancel($userid, $productId, $serialId);
    } else {

    }
    unset($_POST['cancelItem']);
}
if (isset($_POST['buyItem'])){
    $serialId = $_POST['serialId'];
    $sellerId = $_POST['sellerId'];
    if (validateToken("serialId", $serialId) && validateToken("sellerId", $sellerId)) {
        $productManager->buyItem($productId, $serialId, $userid, $sellerId);
    }
    unset($_POST['buyItem']);
}
?>
<link rel="stylesheet" href="../../css/p_product.css">
<title>Products</title>

<section class="product-parent1">
<div class="parent-L">
        <div class="prodImg">
            <div class="prod1">
                <p>Rank: </p>
                <span class="material-symbols-outlined">favorite</span>
            </div>
            <img id="image" class="prod2" src="<?php echo "../../images". $productImage ?>" alt="">
        </div>

        <div class="prodLbody">
            <div onclick="showDiscription()" class="discription">
                <div class="disc1"><span class="material-symbols-outlined">sort</span><h1>&nbsp; Description</h1></div>
                <div class="disc1"><span id="discriptionI" class="material-symbols-outlined">expand_more</span></div>
            </div>
            <div class="discriptionC" id="discriptionC"><p>Discription:</p><br>
                <p><?php echo $productDiscription  ?></p>
            </div>
            <div onclick="showDeveloper()" class="developer">
                <div class="disc1"><span class="material-symbols-outlined">engineering</span><h1>&nbsp; Developer</h1></div>
                <div class="disc1"><span id="developerI" class="material-symbols-outlined">expand_more</span></div>
            </div>
            <div class="developerC" id="developerC"><p>about developer:</p><br>
                <p><?php   ?></p>
            </div>
            <div onclick="showTags()" class="progress">
                <div class="disc1"><span class="material-symbols-outlined">bookmark</span><h1>&nbsp; Tags</h1></div>
                <div class="disc1"><span id="progressI" class="material-symbols-outlined">expand_more</span></div>
            </div>
            <div class="progressC" id="progressC"><p>product tags:</p><br>
                <p><?php   ?></p>
            </div>
        </div>
    </div>

<div class="parent-R">
    <div class="prod1_1">
        <p><?php echo $productCreator ?></p>
        <div class="Psocials">
            <span class="material-symbols-outlined">share</span>
            <span class="material-symbols-outlined">more_horiz</span>
        </div>
    </div>
<div class="Pmaininfo">
    <div class="productmedal">
      <span class="material-symbols-outlined">social_leaderboard</span>
      <?php
          if ($productMedal > 1000000) {
              showMedal(9);
          } elseif ($productMedal > 500000) {
              showMedal(9);
          } elseif ($productMedal > 250000) {
              showMedal(8);
          } elseif ($productMedal > 100000) {
              showMedal(7);
          } elseif ($productMedal > 50000) {
              showMedal(6);
          } elseif ($productMedal > 10000) {
              showMedal(5);
          } elseif ($productMedal > 5000) {
              showMedal(4);
          } elseif ($productMedal > 1000) {
              showMedal(3);
          } elseif ($productMedal > 100) {
              showMedal(2);
          } else {
              showMedal(1);
          }
      ?>
    </div>
    <h1 class="pname"><?php echo $productName ?></h1>
    <div class="Pnav">
        <div class="views"><span class="material-symbols-outlined">visibility</span>&nbsp;  <?php echo $productViews ?> Views</div>
        <div class="favorites"><span class="material-symbols-outlined">star</span>&nbsp;  <?php echo $productFavorites ?> Favorites</div>
        <div class="likes">
        <div class="likes2">
            <span class="material-symbols-outlined">thumbs_up_down</span>
            <p>&nbsp; likes</p>
        </div>
        <div class="precentage-parent">
            <p><?php echo $productLikes ?></p>
            <div class="precentage"></div>
            <p><?php echo $productDislikes ?></p>
        </div></div>
    </div>
</div>
<h1 class="sellersH1">Top resellers</h1>
        <div id="resellersbody" class="sellers-parent">
            <div class="sellers">
                <?php
                $allResselers = $productManager->resellers($productId, $userid);
                if ($allResselers == false){?>
                <div class="noResellers">
                    <h1>no Resellers</h1>
                </div>
                <script>
                    document.getElementById('resellersbody').style.height = "auto";
                    document.getElementById('resellersbody').style.overflow = "hidden";
                </script>
                <?php
                }
                ?>
            </div>
        </div>

        <h1 class="ownedItemsH1">Your Items</h1>
        <div id="Itemsbody" class="owner-parent">
            <div class="ownerItems">
                <?php
                $checkIfownproduct = $productManager->ownedProducts($productManager, $productId, $userid);
                if ($checkIfownproduct == false){?>
                    <div class="noResellers">
                        <h1>no Items Owned</h1>
                    </div>
                    <script>
                        document.getElementById('Itemsbody').style.height = "auto";
                        document.getElementById('Itemsbody').style.overflow = "hidden";
                    </script>
                    <?php
                    }
                    ?>
            </div>
        </div>
    </div>
</section>

<section class="product-parent2">
    <div class="price-history-parent">
        <h1>Price History</h1>
        <div id="myChart" class="pricehistory"></div>
    </div>
    <div class="more"></div>
</section>

<section class="product-parent3">
  <?php
  $productManager->getDevItems(1, $productCreator);
  $productManager->getDevItems(2, $productCreator);
  ?>
</section>



<?php
$maandenData = $productManager->getdataforGrapic($productId);
$currentMonth = date('F');
$maanden = [];
for ($i = 0; $i < 12; $i++) {
    $month = date('M', strtotime("+$i months", strtotime($currentMonth)));
    $maanden[] = $month;
}
$maandenArray = explode(",", $maandenData);
$prijzen = array_map('intval', $maandenArray);
?>

<table id="myTable" class="GraphmyTable">
  <thead>
    <tr>
      <th>Maand</th>
      <th>Prijs</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $maanden = array_reverse($maanden);
    $prijzen = array_reverse($prijzen);

    $currentYear = date("Y");
    $previousYear = $currentYear - 1;

    for ($i = 0; $i < count($maanden); $i++) {
        $maand = $maanden[$i];
        $prijs = isset($prijzen[$i]) ? $prijzen[$i] : '';

        echo '<tr>';
        echo '<td>' . $maand . '</td>';
        echo '<td>' . $prijs . '</td>';
        echo '</tr>';
    }
    ?>
  </tbody>
</table>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
  // Haal de data uit de tabel en verwerk deze
  var table = document.getElementById('myTable');
  var rows = table.getElementsByTagName('tr');
  var labels = [];
  var data = [];

  for (var i = 1; i < rows.length; i++) {
    var cells = rows[i].getElementsByTagName('td');
    var maand = cells[0].innerText;
    var prijs = parseFloat(cells[1].innerText);

    labels.push(maand);
    data.push(prijs);
  }

  // Laad de Google Charts API in
  google.charts.load('current', {
    packages: ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);

  // Maak het lijndiagram met de data
  function drawChart() {
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn('string', 'Months');
    dataTable.addColumn('number', 'Price');

    for (var i = 0; i < labels.length; i++) {
      dataTable.addRow([labels[i], data[i]]);
    }

    var options = {
      hAxis: {
        title: 'Months <?php echo $currentYear . " - " . $previousYear; ?>'
      },
      vAxis: {
        title: 'Price'
      },
      series: {
        1: {
          curveType: 'function'
        }
      }
    };

    var chart = new google.visualization.LineChart(document.getElementById('myChart'));
    chart.draw(dataTable, options);
  }

  var showDiscriptionC = false;
  var showDeveloperC = false;
  var showTagsC = false;

  function toggleElement(elementId, arrowId, bool) {
      var element = document.getElementById(elementId);
      var arrow = document.getElementById(arrowId);
      element.classList.toggle("show");
      if (bool == true){
        element.style.opacity = 1;
        arrow.style.transform = "rotate(180deg)";
      }else{
        element.style.opacity = 1;
        arrow.style.transform = "rotate(0deg)";
      }
  }

  function showDiscription() {
    if (showDiscriptionC == false){
      showDiscriptionC = true;
      toggleElement("discriptionC", "discriptionI", true);
    }else
    if (showDiscriptionC == true){ showDiscriptionC = false;
      toggleElement("discriptionC", "discriptionI", false);
    }
  }
  function showDeveloper() {
    if (showDeveloperC == false){ showDeveloperC = true;
      toggleElement("developerC", "developerI", true);
    }else
    if (showDeveloperC == true){ showDeveloperC = false;
      toggleElement("developerC", "developerI", false);
    }
  }
  function showTags() {
    if (showTagsC == false){ showTagsC = true;
        toggleElement("progressC", "progressI", true);
    }else
    if (showTagsC == true){ showTagsC = false;
      toggleElement("progressC", "progressI", false);
    }
  }
</script>
<?php
include_once("../../includes/defaults/footer.php");