<?php
// include file koneksi.php
include 'koneksi.php';
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');


// Fungsi Create (Tambah Data)
function tambahData($data) {
    global $koneksi;

    $nama = $data['nama'];
    $no_bp = $data['no_bp'];
    $no_hp = $data['no_hp'];
    $email = $data['email'];

    $query = "INSERT INTO tb_pegawai (nama, no_bp, no_hp, email) VALUES ('$nama', '$no_bp', '$no_hp', '$email')";

    if(mysqli_query($koneksi, $query)) {
        $response = [
            'sukses' => true,
            'status' => 200,
            'pesan' => 'Data pegawai berhasil ditambahkan'
        ];
    } else {
        $response = [
            'sukses' => false,
            'status' => 500,
            'pesan' => 'Gagal menambahkan data pegawai: ' . mysqli_error($koneksi)
        ];
    }

    return json_encode($response);
}

// Fungsi Read (Ambil Data)
function ambilData() {
    global $koneksi;

    $query = "SELECT * FROM tb_pegawai";
    $result = mysqli_query($koneksi, $query);

    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return json_encode($data);
}

// Fungsi Update (Edit Data)
function editData($id, $data) {
    global $koneksi;

    $nama = $data['nama'];
    $no_bp = $data['no_bp'];
    $no_hp = $data['no_hp'];
    $email = $data['email'];

    $query = "UPDATE tb_pegawai SET nama='$nama', no_bp='$no_bp', no_hp='$no_hp', email='$email' WHERE id_pegawai=$id";

    if(mysqli_query($koneksi, $query)) {
        $response = [
            'sukses' => true,
            'status' => 200,
            'pesan' => 'Data pegawai berhasil diperbarui'
        ];
    } else {
        $response = [
            'sukses' => false,
            'status' => 500,
            'pesan' => 'Gagal memperbarui data pegawai: ' . mysqli_error($koneksi)
        ];
    }

    return json_encode($response);
}

// Fungsi Delete (Hapus Data)
function hapusData($id) {
    global $koneksi;

    $query = "DELETE FROM tb_pegawai WHERE id_pegawai=$id";

    if(mysqli_query($koneksi, $query)) {
        $response = [
            'sukses' => true,
            'status' => 200,
            'pesan' => 'Data pegawai berhasil dihapus'
        ];
    } else {
        $response = [
            'sukses' => false,
            'status' => 500,
            'pesan' => 'Gagal menghapus data pegawai: ' . mysqli_error($koneksi)
        ];
    }

    return json_encode($response);
}

// Main Program
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Ambil data
        echo ambilData();
        break;
    case 'POST':
        // Cek jika parameter action ada
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
            // Cek jenis action
            switch ($action) {
                case 'tambah':
                    // Tambah data
                    echo tambahData($_POST);
                    break;
                case 'edit':
                    // Cek jika parameter id_pegawai ada
                    if(isset($_POST['id_pegawai'])) {
                        $id = $_POST['id_pegawai'];
                        // Edit data
                        echo editData($id, $_POST);
                    } else {
                        echo json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'ID pegawai tidak ditemukan']);
                    }
                    break;
                case 'hapus':
                    // Cek jika parameter id_pegawai ada
                    if(isset($_POST['id_pegawai'])) {
                        $id = $_POST['id_pegawai'];
                        // Hapus data
                        echo hapusData($id);
                    } else {
                        echo json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'ID pegawai tidak ditemukan']);
                    }
                    break;
                default:
                    echo json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'Aksi tidak valid']);
                    break;
            }
        } else {
            echo json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'Aksi tidak ditemukan']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['sukses' => false, 'status' => 405, 'pesan' => 'Method tidak diizinkan']);
        break;
}
?>
