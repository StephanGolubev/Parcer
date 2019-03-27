
<html>
<head>
	<title>Parcer</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<!-- немного html -->
<header>
  Fixed navbar
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="">Parcer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="app/categories.php">Scan site categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="app/catalog.php">Scan site catalog</a>
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
 <?php 
//  достаем все каталоги
 require_once 'app/classes/db.php';

 $con = new DB();
 $res = $con->BuildSelect("categories");
 while($row = mysqli_fetch_array($res)){
  //  формируем card с ссылкой и id каталога
  echo '<div class="col-sm-6">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">'.$row['name'].'</h5>
      <a href="http://localhost/parcer/view/catalog.php?id='. $row['id'] .'" class="btn btn-primary">Go to see all cards</a>
    </div>
  </div>
  </div>';
}
 ?>
 <br><br>
 <br></body>
</html>

