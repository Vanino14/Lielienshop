<?php
 include "config.php";
 session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>LieLien Shop</title>
</head>
<body>
  <video autoplay muted loop id="myVideo">
    <source src="img/background.mp4" type="video/mp4">
  </video>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid" style="background-color: white;">
          <a class="navbar-brand" href="index.html"><img src="img/logo.jpg" class="logo"><strong class="brand-text">LIELIEN SHOP</strong></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="catalog.php">Catalogue</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="cart.php">Cart</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"href="logout.php">Logout</a>
              </li>
              <li class="nav-item">
                <?php
                if(isset($_SESSION['name'])){
                  $username=$_SESSION['name'];
                  $query = "SELECT nama FROM pengguna WHERE name = '$username'";
                  echo ' <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
                  <a class="nav-link"> Welcome '.$username.'</a>';
                }else {header("Location:login.php");exit();}
                ?>
              </li>
            </ul>
        </div>
        </div>
      </nav>
<!--BODY-->
<div class="container offset-lg-2 my-5">
<?php
$nama_pengguna = $_SESSION['name'];

// Query untuk mendapatkan ID pengguna berdasarkan nama pengguna
$query = "SELECT id_pengguna FROM pengguna WHERE name = '$nama_pengguna'";
$result = mysqli_query($conn, $query);


if ($result === false) {
  // Penanganan kesalahan query
  die("Query error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_assoc($result);
  $id_pengguna = $row['id_pengguna'];

  // Gunakan ID pengguna untuk mendapatkan data keranjang
  $query_keranjang = "SELECT keranjang.*, produk.* FROM keranjang LEFT JOIN produk ON keranjang.id_produk = produk.id_produk WHERE keranjang.id_pengguna = '$id_pengguna'";
  $result_keranjang = mysqli_query($conn, $query_keranjang);

  if ($result_keranjang === false) {
    // Penanganan kesalahan query
    die("Query error: " . mysqli_error($conn));
  }

  if (mysqli_num_rows($result_keranjang) > 0) {
    $no = 1;
    while ($row = mysqli_fetch_array($result_keranjang)) {
      ?>

      <div class="card mb-3" style="max-width: 90%;">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['gambar']); ?>" class="img-fluid rounded-start" style="width:22rem;height:15rem;" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nama_produk'] ?></h5>
              <p class="card-text"><?php echo $row['deskripsi_produk'] ?></p>
              <p class="card-text"><small class="text-body-secondary"><?php echo $row['tanggal'] ?></small></p>
              <?php $formattedNumber = number_format($row['harga_produk'], 0, ',', '.'); ?>
              <p class="card-text">Rp. <?php echo $formattedNumber ?></p>
              <input type="number" class="form-control" value="<?php echo $row['quantity'] ?>" min="1" name="quantity" onchange="validateQuantity(this)">
              <p class="card-text"><?php echo $row['harga_produk'] * $row['quantity'] ?><p>
            </div>
          </div>
        </div>
      </div>

    <?php
    }
  } else {
    // Tampilkan pesan bahwa keranjang belanja kosong
    echo "Anda belum memiliki item di keranjang belanja.";
  }
}
?>
</div>


<!--BODY-->

<!-- Footer -->
<footer class="text-center text-lg-start bg-white text-muted">
  <!-- Section: Social media -->
  <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    <!-- Left -->
    <div class="me-5 d-none d-lg-block">
      <span>Get connected with us on social networks:</span>
    </div>
    <!-- Left -->

    <!-- Right -->
    <div>
      <a href="" class="me-4 link-secondary">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="" class="me-4 link-secondary">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="" class="me-4 link-secondary">
        <i class="fab fa-google"></i>
      </a>
      <a href="" class="me-4 link-secondary">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="" class="me-4 link-secondary">
        <i class="fab fa-linkedin"></i>
      </a>
      <a href="" class="me-4 link-secondary">
        <i class="fab fa-github"></i>
      </a>
    </div>
    <!-- Right -->
  </section>
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="">
    <div class="container text-center text-md-start mt-3 mb-3">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-6 text-secondary"></i>LIELIEN SHOP
          </h6>
          <p>
            Sejak 2018 telah berdiri sebagai toko aksesoris serta bahan mentah aksesoris.
            Memiliki kualitas premium.
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Products
          </h6>
          <p>
            <a href="#!" class="text-reset">Gelang</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Kalung</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Cincin</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Bahan mentah</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Useful links
          </h6>
          <p>
            <a href="#!" class="text-reset">Pricing</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Settings</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Orders</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Help</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-3">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p><i class="fas fa-home me-6 text-secondary"></i> JL.RA Kartini GG. Manggis Raya No. 36</p>
          <p>
            <i class="fas fa-envelope me-6 text-secondary"></i>
            Lielienshop@gmail.com
          </p>
          <p><i class="fas fa-phone me-6 text-secondary"></i> +62812645782</p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-2" style="background-color: rgba(0, 0, 0, 0.025);">
    © 2023 Copyright:
    <a class="text-reset fw-bold" href="#">Lielienshop.com</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>