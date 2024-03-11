<?php

include 'koneksi.php';

// Fungsi untuk membaca data dari tabel berita
function bacaDataBerita() {
    global $koneksi;
    $sql = "SELECT * FROM tb_berita";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk membaca data dari tabel pegawai
function bacaDataPegawai() {
    global $koneksi;
    $sql = "SELECT * FROM tb_pegawai";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk membaca data dari tabel galeri
function bacaDataGaleri() {
    global $koneksi;
    $sql = "SELECT * FROM tb_galeri";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk membaca data dari tabel user
function bacaDataUser() {
    global $koneksi;
    $sql = "SELECT * FROM tb_user";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk mengembalikan response API
function kirimResponse($sukses, $status, $pesan, $data) {
    $response = [
        'sukses' => $sukses,
        'status' => $status,
        'pesan' => $pesan,
        'data' => $data
    ];
    echo json_encode($response);
}

// Endpoint untuk membaca data berita
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'berita') {
    $data = bacaDataBerita();
    kirimResponse(true, 200, 'Data berita berhasil diambil', $data);
}

// Endpoint untuk membaca data pegawai
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'pegawai') {
    $data = bacaDataPegawai();
    kirimResponse(true, 200, 'Data pegawai berhasil diambil', $data);
}

// Endpoint untuk membaca data galeri
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'galeri') {
    $data = bacaDataGaleri();
    kirimResponse(true, 200, 'Data galeri berhasil diambil', $data);
}

// Endpoint untuk membaca data user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'user') {
    $data = bacaDataUser();
    kirimResponse(true, 200, 'Data user berhasil diambil', $data);
}

// Menutup koneksi database
mysqli_close($koneksi);
?>
