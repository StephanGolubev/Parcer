<html>
<head>
	<title>Cards</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <meta charset="utf-8"/>
</head>
<header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="">Parcer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="../index.php">Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../app/categories.php">Scan site categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../app/catalog.php">Scan site catalog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Scan site cards</a>
        </li>
      </ul>
      <div class="dropdown" style="margin-top: -19px;">
  <button class="btn btn-outline-success my-2 my-sm-0" type="button" >Search result</button>
  <div class="dropdown-content">
    <div id="search-result-container" style="border:solid 1px #BDC7D8;display:none; "></div>
  </div>
</div>
      <div class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-1" type="text" id="search-data" name="searchData" placeholder="Search By Post Title (word length should be greater than 3) ..." autocomplete="off" aria-label="Search">
      </div>
      
      </div>
    </div>
  </nav>
</header>
<body>
<br>
<?php 
 require_once '../app/classes/db.php';
 $con = new DB();
 //  $res = $con->BuildSelect("card");
$num = $_GET['id'];
 $sql = "SELECT * FROM card WHERE category='$num'";
$result = $con->getRows($sql);
$count = 0;
echo '<div class="row">';
for ($i=0; $i < count($result); $i++) { 
    echo '<div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">'.$result[$i]['name'].'</h5>
        <p class="card-text">'.$result[$i]['coutry'].'</p>
        <p class="card-text">'.$result[$i]['creator'].'</p>
        <a href="#" class="btn btn-primary">None</a>
      </div>
    </div>
  </div>
  ';

}
?>






</body>
</html>