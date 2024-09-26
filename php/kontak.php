<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Kontak</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="kontak.php">
            <img src="images/kontak.png" alt="">
            <span>
              Kontak
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="s-1"> </span>
            <span class="s-2"> </span>
            <span class="s-3"> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="beranda.php">Beranda<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="profil.php">Profil</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="prestasi.php">Prestasi</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="artikel.php">artikel</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="ppdb.php">Ppdb</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="galeri.php">galeri</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="kontak.php">kontak</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- kontak section -->

  <?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_sekolah";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani penyimpanan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $no_telp = $_POST['no_telp'];
        $pesan = $_POST['pesan'];

        // Insert data
        $sql = "INSERT INTO contacts (nama, email, no_telp, pesan) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $email, $no_telp, $pesan);
        $stmt->execute();
        echo "<script>alert('Pesan berhasil dikirim!');</script>";
    } elseif ($_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $no_telp = $_POST['no_telp'];
        $pesan = $_POST['pesan'];

        // Update data
        $sql = "UPDATE contacts SET nama=?, email=?, no_telp=?, pesan=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama, $email, $no_telp, $pesan, $id);
        $stmt->execute();
        echo "<script>alert('Pesan berhasil diperbarui!');</script>";
    }
}

// Menangani penghapusan data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM contacts WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<script>alert('Kontak berhasil dihapus!');</script>";
}

// Mengambil data untuk edit
$contact = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM contacts WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $contact = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .contact_section {
            padding: 20px;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
    <div class="container contact_section">
        <div class="heading_container text-center">
            <h2>Kontak</h2>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?= $contact ? $contact['id'] : '' ?>">
                    <input type="hidden" name="action" value="<?= $contact ? 'edit' : 'add' ?>">
                    <div class="form-group">
                        <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= $contact ? $contact['nama'] : '' ?>" required />
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $contact ? $contact['email'] : '' ?>" required />
                    </div>
                    <div class="form-group">
                        <input type="tel" name="no_telp" class="form-control" placeholder="No Telp" value="<?= $contact ? $contact['no_telp'] : '' ?>" required pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" />
                    </div>
                    <div class="form-group">
                        <input type="pesan" name="pesan" class="form-control" placeholder="Pesan" value="<?= $contact ? $contact['pesan'] : '' ?>" required />
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary"><?= $contact ? 'Perbarui' : 'Kirim' ?></button>
                    </div>
                </form>
            </div>
        </div>

        <h2 class="text-center">Daftar Kontak</h2>
        <?php
        $sql = "SELECT * FROM contacts";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered table-striped'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telp</th>
                            <th>Pesan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["nama"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["no_telp"] . "</td>
                        <td>" . $row["pesan"] . "</td>
                        <td>" . $row["created_at"] . "</td>
                        <td>
                            <a href='?edit=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='?delete=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\");'>Delete</a>
                        </td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-center'>Tidak ada kontak.</p>";
        }

        // Menutup koneksi
        $conn->close();
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      </div>
</body>
</html>

  <!-- end kontak section -->


  <!-- info section -->

  <section class="info_section layout_padding">
    <div class="container">
      <div class="info_contact">
        <div class="row">
          <div class="col-md-4">
            <a href="">
              <img src="images/location-white.png" alt="">
              <span>
                Jl. Raya Bayongbong Km.5 Ds Mangkurayat Kec.Cilawu-Garut
              </span>
            </a>
          </div>
          <div class="col-md-4">
            <a href="">
              <img src="images/telephone-white.png" alt="">
              <span>
                No Telp: (0262) 2248203
              </span>
            </a>
          </div>
          <div class="col-md-4">
            <a href="">
              <img src="images/envelope-white.png" alt="">
              <span>
                smpnduacilawu@yahoo.co.id
              </span>
            </a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 col-lg-9">
          <div class="info_form">
            <form action="">
              <input type="text" placeholder="Masukkan Email Anda">
              <button>
                Kirim
              </button>
            </form>
          </div>
        </div>
        <div class="col-md-4 col-lg-3">
          <div class="info_social">
            <div>
              <a href="https://www.facebook.com/smpn2cilawu/?locale=id_ID">
                <img src="images/fb.png" alt="">
              </a>
            </div>
            <div>
              <a href="https://twitter.com/smpn_2cilawu">
                <img src="images/twitter.png" alt="">
              </a>
            </div>
            <div>
              <a href="https://www.instagram.com/smpn2cilawu_/?igsh=MTI5NDE1bTR0OXE5aA%3D%3D">
                <img src="images/instagram.png" alt="">
              </a>
            </div>
            <div>
              <a href="https://www.youtube.com/@smpn2cilawugarutofficial194/videos">
                <img src="images/youtube.png" alt="">
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- end info section -->

  <!-- footer section -->
  <footer class="container-fluid footer_section">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 col-md-9 mx-auto">
          <p>
            &copy; 2024 CopyRight SMP Negeri 2 Cilawu
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- footer section -->


  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>

</body>

</html>