<?php
// session_start();
if (!isset($_SESSION['users'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['users']['role'] == "admin") {
    if (isset($_GET['dashboard'])) {
        include 'modular/dashboard.php';
    } else if (isset($_GET['info_magang'])) { //pendaftaran_magang
        include 'modular/info_magang.php';
    } else if (isset($_GET['add_info_magang'])) { //pendaftaran_magang
        include 'modular/add_info_magang.php';
    } else if (isset($_GET['data_pendaftaran_magang'])) { //pendaftaran_magang
        include 'modular/data_pendaftaran_magang.php';
    } else if (isset($_GET['data_magang_diterima'])) {
        include 'modular/data_magang_diterima.php';
    } else if (isset($_GET['data_magang_ditolak'])) {
        include 'modular/data_magang_ditolak.php';
    } else if (isset($_GET['data_dosen_pembimbing'])) { //dosen_pembimbing
        include 'modular/data_dosen_pembimbing.php';
    } else if (isset($_GET['add_dosen_pembimbing'])) {
        include 'modular/add_dosen_pembimbing.php';
    } else if (isset($_GET['edit_dosen_pembimbing'])) {
        include 'modular/edit_dosen_pembimbing.php';
    } else if (isset($_GET['hapus_dosen_pembimbing'])) {
        include 'modular/hapus_dosen_pembimbing.php';
    } else if (isset($_GET['data_dosen_penguji'])) { //dosen_penguji
        include 'modular/data_dosen_penguji.php';
    } else if (isset($_GET['add_dosen_penguji'])) {
        include 'modular/add_dosen_penguji.php';
    } else if (isset($_GET['edit_dosen_penguji'])) {
        include 'modular/edit_dosen_penguji.php';
    } else if (isset($_GET['hapus_dosen_penguji'])) {
        include 'modular/hapus_dosen_penguji.php';
    } else if (isset($_GET['data_mahasiswa'])) { //mahasiswa
        include 'modular/data_mahasiswa.php';
    } else if (isset($_GET['add_mahasiswa'])) {
        include 'modular/add_mahasiswa.php';
    } else if (isset($_GET['edit_mahasiswa'])) {
        include 'modular/edit_mahasiswa.php';
    } else if (isset($_GET['hapus_mahasiswa'])) {
        include 'modular/hapus_mahasiswa.php';
    } else if (isset($_GET['add_jadwal'])) { //jadwal
        include 'modular/add_jadwal.php';
    } else if (isset($_GET['data_jadwal'])) {
        include 'modular/data_jadwal.php';
    } else if (isset($_GET['edit_data_jadwal'])) {
        include 'modular/edit_data_jadwal.php';
    } else if (isset($_GET['cetak_laporan'])) { //laporan
        include 'modular/cetak_laporan.php';
    } else if (isset($_GET['cetak_jadwal'])) { //laporan
        include 'modular/cetak_jadwal.php';
    } else if (isset($_GET['laporan_proses'])) {
        include 'laporan_proses.php';
    } else if (isset($_GET['laporan_selesai'])) {
        include 'laporan_selesai.php';
    } else {
        include 'modular/dashboard.php';
    }
} elseif ($_SESSION['users']['role'] == "mahasiswa") {
    if (isset($_GET['dashboard_mahasiswa'])) {
        include 'modular/dashboard_mahasiswa.php';
    } else if (isset($_GET['Pendaftaran_magang'])) {
        include 'modular/Pendaftaran_magang.php';
    } else if (isset($_GET['Pengumuman_magang'])) {
        include 'modular/Pengumuman_magang.php';
    } else if (isset($_GET['detail_jadwal'])) {
        include 'modular/detail_jadwal.php';
    } else if (isset($_GET['bimbingan_magang'])) {
        include 'modular/bimbingan_magang.php';
    } else if (isset($_GET['data_bimbingan'])) {
        include 'modular/data_bimbingan.php';
    } else if (isset($_GET['revisi_bimbingan_magang'])) {
        include 'modular/revisi_bimbingan_magang.php';
    } else if (isset($_GET['laporan_magang'])) {
        include 'modular/laporan_magang.php';
    } else if (isset($_GET['lihat_nilai'])) {
        include 'modular/lihat_nilai.php';
    } else {
        include 'modular/dashboard_mahasiswa.php';
    }
} elseif ($_SESSION['users']['role'] == "dosen_penguji") {
    if (isset($_GET['dashboard_penguji'])) {
        include 'modular/dashboard_penguji.php';
    } else if (isset($_GET['data_jadwal_penguji'])) {
        include 'modular/data_jadwal_penguji.php';
    } else if (isset($_GET['data_laporan_magang'])) {
        include 'modular/data_laporan_magang.php';
    } else if (isset($_GET['penilaian'])) {
        include 'modular/penilaian.php';
    } else if (isset($_GET['data_nilai'])) {
        include 'modular/data_nilai.php';
    } else if (isset($_GET['cetak_nilai'])) {
        include 'modular/cetak_nilai.php';
    } else {
        include 'modular/dashboard_penguji.php';
    }
} elseif ($_SESSION['users']['role'] == "dosen_pembimbing") {
    if (isset($_GET['dashboard_pembimbing'])) {
        include 'modular/dashboard_pembimbing.php';
    } else if (isset($_GET['data_jadwal_pembimbing'])) {
        include 'modular/data_jadwal_pembimbing.php';
    } else if (isset($_GET['catatan_bimbingan'])) {
        include 'modular/catatan_bimbingan.php';
    } else if (isset($_GET['nilai_bimbingan'])) {
        include 'modular/nilai_bimbingan.php';
    } else if (isset($_GET['penilaian_bimbingan'])) {
        include 'modular/penilaian_bimbingan.php';
    } else if (isset($_GET['detail_catatan_bimbingan'])) {
        include 'modular/detail_catatan_bimbingan.php';
    } else {
        include 'modular/dashboard_pembimbing.php';
    }
}
