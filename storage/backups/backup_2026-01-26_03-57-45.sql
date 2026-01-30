-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: esuratglobalitiB
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `backup_letters`
--

DROP TABLE IF EXISTS `backup_letters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `backup_letters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `backup_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('surat_masuk','surat_keluar','all') COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_letters` int NOT NULL,
  `total_attachments` int NOT NULL,
  `file_size` bigint NOT NULL DEFAULT '0',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `backup_letters_created_by_foreign` (`created_by`),
  CONSTRAINT `backup_letters_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_letters`
--

LOCK TABLES `backup_letters` WRITE;
/*!40000 ALTER TABLE `backup_letters` DISABLE KEYS */;
INSERT INTO `backup_letters` VALUES (5,'backup_surat_all_2026-01-26_03-57-08.zip','all',200,2,202852,'backups/letters/backup_surat_all_2026-01-26_03-57-08.zip',1,NULL,'2026-01-25 19:57:08','2026-01-25 19:57:08');
/*!40000 ALTER TABLE `backup_letters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disposisi`
--

DROP TABLE IF EXISTS `disposisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disposisi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `surat_masuk_id` bigint unsigned NOT NULL,
  `disposisi_ke` bigint unsigned NOT NULL,
  `isi_disposisi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan_kepala_sekolah` text COLLATE utf8mb4_unicode_ci,
  `tanda_tangan_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','received','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `received_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disposisi_surat_masuk_id_foreign` (`surat_masuk_id`),
  KEY `disposisi_disposisi_ke_foreign` (`disposisi_ke`),
  KEY `disposisi_created_by_foreign` (`created_by`),
  CONSTRAINT `disposisi_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `disposisi_disposisi_ke_foreign` FOREIGN KEY (`disposisi_ke`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `disposisi_surat_masuk_id_foreign` FOREIGN KEY (`surat_masuk_id`) REFERENCES `surat_masuk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disposisi`
--

LOCK TABLES `disposisi` WRITE;
/*!40000 ALTER TABLE `disposisi` DISABLE KEYS */;
/*!40000 ALTER TABLE `disposisi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2024_01_01_000001_create_users_table',1),(2,'2024_01_01_000002_create_surat_masuk_table',1),(3,'2024_01_01_000003_create_disposisi_table',1),(4,'2024_01_01_000004_create_surat_keluar_table',1),(5,'2026_01_09_000001_update_role_enum_in_users_table',1),(6,'2026_01_09_024920_create_sessions_table',1),(7,'2026_01_09_025505_create_cache_table',1),(8,'2026_01_12_000003_add_archive_to_surat_masuk_table',1),(9,'2026_01_12_000004_add_archive_to_surat_keluar_table',1),(10,'2026_01_12_000005_add_diarsip_status_to_surat_tables',1),(11,'2026_01_12_000006_create_tanda_tangan_table',1),(12,'2026_01_15_000001_create_backup_letters_table',1),(13,'2026_01_25_add_no_hp_to_users_table',1),(14,'2026_01_25_change_user_role_to_staff',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_keluar`
--

DROP TABLE IF EXISTS `surat_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat_keluar` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tujuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perihal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_surat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published','diarsip') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surat_keluar_nomor_surat_unique` (`nomor_surat`),
  KEY `surat_keluar_created_by_foreign` (`created_by`),
  CONSTRAINT `surat_keluar_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_keluar`
--

LOCK TABLES `surat_keluar` WRITE;
/*!40000 ALTER TABLE `surat_keluar` DISABLE KEYS */;
INSERT INTO `surat_keluar` VALUES (1,'SK-0001/2024','2024-07-28','Dinas Kesehatan','Permohonan Donasi untuk Sekolah','Sesuai dengan surat tugas, peserta didik diharapkan untuk mengikuti kegiatan...',NULL,'published',0,NULL,3,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(2,'SK-0002/2024','2024-09-07','Tim Verifikasi Sekolah','Permohonan Donasi untuk Sekolah','Untuk keperluan administrasi akademik, kami membutuhkan data lengkap mengenai...',NULL,'draft',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(3,'SK-0003/2024','2024-04-15','PT Bank Mandiri','Undangan Seminar Pendidik','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'diarsip',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(4,'SK-0004/2024','2024-04-05','BNN Kabupaten','Permohonan Bantuan Dana','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'diarsip',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(5,'SK-0005/2025','2025-10-04','Kementerian Pendidikan','Surat Kepada Orang Tua Siswa','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'draft',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(6,'SK-0006/2025','2025-12-15','Perusahaan Swasta','Pemberitahuan Perubahan Jadwal','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'draft',0,NULL,14,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(7,'SK-0007/2025','2025-11-06','Kementerian Pendidikan','Pemberitahuan Perubahan Jadwal','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'diarsip',0,NULL,15,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(8,'SK-0008/2025','2025-05-13','Perusahaan Swasta','Permohonan Donasi untuk Sekolah','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'diarsip',0,NULL,10,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(9,'SK-0009/2024','2024-05-10','Kementerian Pendidikan','Surat Minta Maaf','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'diarsip',0,NULL,10,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(10,'SK-0010/2024','2024-12-08','Dinas Pendidikan Provinsi','Surat Pemberitahuan Kegiatan','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'published',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(11,'SK-0011/2024','2024-11-23','Sekolah Mitra Kerjasama','Rekomendasi Beasiswa','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'published',0,NULL,15,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(12,'SK-0012/2024','2024-02-01','Perusahaan Swasta','Laporan Kegiatan Ekstrakurikuler','Sesuai dengan surat tugas, peserta didik diharapkan untuk mengikuti kegiatan...',NULL,'draft',0,NULL,3,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(13,'SK-0013/2024','2024-10-13','Perusahaan Swasta','Nota Dinas Akademik','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'published',0,NULL,13,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(14,'SK-0014/2025','2025-01-01','Panitia Event Kabupaten','Surat Tugas Peserta Didik','Berdasarkan evaluasi yang telah dilakukan, kami melaporkan bahwa...',NULL,'draft',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(15,'SK-0015/2025','2025-07-02','Yayasan Pendidikan','Laporan Rencana Program Tahunan','Berdasarkan evaluasi yang telah dilakukan, kami melaporkan bahwa...',NULL,'diarsip',0,NULL,11,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(16,'SK-0016/2024','2024-08-04','BNN Kabupaten','Surat Kepada Orang Tua Siswa','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'diarsip',0,NULL,11,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(17,'SK-0017/2024','2024-07-26','Dinas Perindustrian','Permohonan Donasi untuk Sekolah','Untuk keperluan administrasi akademik, kami membutuhkan data lengkap mengenai...',NULL,'diarsip',0,NULL,5,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(18,'SK-0018/2025','2025-06-20','Kementerian Pendidikan','Surat Pemberitahuan Kegiatan','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'draft',0,NULL,8,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(19,'SK-0019/2024','2024-03-08','Dinas Perindustrian','Laporan Hasil Evaluasi','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'draft',0,NULL,5,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(20,'SK-0020/2025','2025-03-04','BNN Kabupaten','Laporan Hasil Evaluasi','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'draft',0,NULL,5,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(21,'SK-0021/2024','2024-11-19','Kantor Pajak','Permintaan Dukungan Program','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'draft',0,NULL,9,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(22,'SK-0022/2024','2024-04-02','Polres Kabupaten','Nota Dinas Akademik','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'published',0,NULL,9,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(23,'SK-0023/2024','2024-03-10','Kantor Walikota','Pernyataan Kemitraan Kerjasama','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'draft',0,NULL,8,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(24,'SK-0024/2025','2025-07-08','Badan Sosial','Pernyataan Kemitraan Kerjasama','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'draft',0,NULL,11,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(25,'SK-0025/2025','2025-10-23','Organisasi Induk Sekolah','Surat Tugas Peserta Didik','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'draft',0,NULL,13,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(26,'SK-0026/2024','2024-05-09','Universitas Negeri','Surat Penawaran Layanan','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'draft',0,NULL,3,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(27,'SK-0027/2025','2025-03-12','Komite Orang Tua Peserta Didik','Permohonan Magang','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'diarsip',0,NULL,9,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(28,'SK-0028/2024','2024-04-21','Universitas Negeri','Permintaan Dukungan Program','Untuk keperluan administrasi akademik, kami membutuhkan data lengkap mengenai...',NULL,'published',0,NULL,5,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(29,'SK-0029/2024','2024-02-18','Organisasi Induk Sekolah','Undangan Kegiatan Sekolah','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'draft',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(30,'SK-0030/2025','2025-03-16','Perusahaan Swasta','Surat Pemberitahuan Kegiatan','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'published',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(31,'SK-0031/2025','2025-10-22','Tim Verifikasi Sekolah','Permohonan Bantuan Dana','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'published',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(32,'SK-0032/2025','2025-02-28','Dinas Pendidikan Provinsi','Laporan Kegiatan Ekstrakurikuler','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'draft',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(33,'SK-0033/2025','2025-04-21','Koperasi Sekolah','Surat Tugas Peserta Didik','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'draft',0,NULL,9,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(34,'SK-0034/2025','2025-05-06','Yayasan Pendidikan','Permohonan Magang','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'published',0,NULL,8,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(35,'SK-0035/2024','2024-01-10','Universitas Negeri','Surat Pemberitahuan Kegiatan','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'draft',0,NULL,3,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(36,'SK-0036/2025','2025-08-11','PT Bank Mandiri','Surat Tugas Peserta Didik','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'draft',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(37,'SK-0037/2025','2025-01-20','Organisasi Induk Sekolah','Nota Dinas Akademik','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'draft',0,NULL,3,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(38,'SK-0038/2025','2025-11-25','Kantor Pajak','Laporan Kegiatan Ekstrakurikuler','Berdasarkan evaluasi yang telah dilakukan, kami melaporkan bahwa...',NULL,'diarsip',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(39,'SK-0039/2024','2024-10-08','Dinas Pendidikan Provinsi','Pengajuan Proposal Kegiatan','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'draft',0,NULL,3,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(40,'SK-0040/2024','2024-05-11','Koperasi Sekolah','Nota Dinas Akademik','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'diarsip',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(41,'SK-0041/2025','2025-09-13','Universitas Negeri','Pernyataan Kemitraan Kerjasama','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'draft',0,NULL,14,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(42,'SK-0042/2025','2025-12-10','Universitas Negeri','Nota Dinas Akademik','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'draft',0,NULL,16,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(43,'SK-0043/2024','2024-04-17','Kantor Pajak','Laporan Kegiatan Ekstrakurikuler','Kami dengan senang hati merekomendasikan siswa-siswi berprestasi untuk mendapat beasiswa...',NULL,'diarsip',0,NULL,11,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(44,'SK-0044/2025','2025-04-18','DPPKB Kabupaten','Surat Pemberitahuan Kegiatan','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'draft',0,NULL,4,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(45,'SK-0045/2024','2024-10-07','Polres Kabupaten','Rekomendasi Beasiswa','Kami dengan senang hati merekomendasikan siswa-siswi berprestasi untuk mendapat beasiswa...',NULL,'published',0,NULL,10,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(46,'SK-0046/2025','2025-07-10','Kantor Pajak','Surat Tugas Peserta Didik','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'published',0,NULL,16,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(47,'SK-0047/2025','2025-07-07','Sekolah Mitra Kerjasama','Surat Penawaran Layanan','Untuk keperluan administrasi akademik, kami membutuhkan data lengkap mengenai...',NULL,'diarsip',0,NULL,5,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(48,'SK-0048/2025','2025-06-21','Universitas Negeri','Surat Penawaran Layanan','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'published',0,NULL,14,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(49,'SK-0049/2024','2024-06-23','Organisasi Induk Sekolah','Nota Dinas Akademik','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'published',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(50,'SK-0050/2024','2024-04-25','Komite Orang Tua Peserta Didik','Surat Minta Maaf','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'draft',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(51,'SK-0051/2024','2024-06-01','Komite Orang Tua Peserta Didik','Surat Penawaran Layanan','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'published',0,NULL,15,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(52,'SK-0052/2025','2025-08-22','Dinas Pendidikan Provinsi','Surat Minta Maaf','Kami dengan senang hati merekomendasikan siswa-siswi berprestasi untuk mendapat beasiswa...',NULL,'diarsip',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(53,'SK-0053/2025','2025-02-22','BNN Kabupaten','Surat Pemberitahuan Kegiatan','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'draft',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(54,'SK-0054/2024','2024-05-11','Kementerian Pendidikan','Undangan Seminar Pendidik','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'published',0,NULL,10,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(55,'SK-0055/2025','2025-03-17','DPPKB Kabupaten','Pengajuan Proposal Kegiatan','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'draft',0,NULL,11,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(56,'SK-0056/2024','2024-04-01','Kantor Walikota','Undangan Seminar Pendidik','Sesuai dengan surat tugas, peserta didik diharapkan untuk mengikuti kegiatan...',NULL,'published',0,NULL,10,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(57,'SK-0057/2025','2025-10-09','Tim Verifikasi Sekolah','Pengajuan Proposal Kegiatan','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'diarsip',0,NULL,8,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(58,'SK-0058/2025','2025-04-24','Perusahaan Swasta','Permohonan Bantuan Dana','Untuk keperluan administrasi akademik, kami membutuhkan data lengkap mengenai...',NULL,'diarsip',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(59,'SK-0059/2024','2024-11-27','Perusahaan Swasta','Surat Minta Maaf','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'diarsip',0,NULL,16,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(60,'SK-0060/2024','2024-11-09','Panitia Event Kabupaten','Laporan Kegiatan Ekstrakurikuler','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'published',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(61,'SK-0061/2024','2024-03-22','Badan Sosial','Pernyataan Kemitraan Kerjasama','Sesuai dengan surat tugas, peserta didik diharapkan untuk mengikuti kegiatan...',NULL,'draft',0,NULL,11,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(62,'SK-0062/2024','2024-07-10','Kementerian Pendidikan','Permintaan Dukungan Program','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'diarsip',0,NULL,4,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(63,'SK-0063/2025','2025-01-02','Dinas Pendidikan Provinsi','Surat Tugas Peserta Didik','Untuk keperluan administrasi akademik, kami membutuhkan data lengkap mengenai...',NULL,'published',0,NULL,10,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(64,'SK-0064/2025','2025-01-02','Badan Sosial','Permohonan Bantuan Dana','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'published',0,NULL,3,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(65,'SK-0065/2025','2025-09-22','Yayasan Pendidikan','Permohonan Magang','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'diarsip',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(66,'SK-0066/2025','2025-01-15','Kementerian Pendidikan','Permohonan Magang','Sesuai dengan surat tugas, peserta didik diharapkan untuk mengikuti kegiatan...',NULL,'published',0,NULL,9,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(67,'SK-0067/2024','2024-10-17','Tim Verifikasi Sekolah','Permohonan Donasi untuk Sekolah','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'draft',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(68,'SK-0068/2025','2025-08-02','Koperasi Sekolah','Surat Tugas Peserta Didik','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'draft',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(69,'SK-0069/2025','2025-08-03','Dinas Pendidikan Provinsi','Surat Minta Maaf','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'published',0,NULL,8,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(70,'SK-0070/2024','2024-06-08','Panitia Event Kabupaten','Rekomendasi Beasiswa','Sesuai dengan surat tugas, peserta didik diharapkan untuk mengikuti kegiatan...',NULL,'published',0,NULL,16,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(71,'SK-0071/2025','2025-08-04','Tim Verifikasi Sekolah','Laporan Kegiatan Ekstrakurikuler','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'published',0,NULL,4,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(72,'SK-0072/2025','2025-12-26','Badan Sosial','Permintaan Dukungan Program','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'diarsip',0,NULL,14,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(73,'SK-0073/2025','2025-10-14','Sekolah Mitra Kerjasama','Surat Minta Maaf','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'published',0,NULL,9,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(74,'SK-0074/2025','2025-10-01','Badan Sosial','Pemberitahuan Perubahan Jadwal','Untuk keperluan administrasi akademik, kami membutuhkan data lengkap mengenai...',NULL,'published',0,NULL,5,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(75,'SK-0075/2025','2025-10-21','Badan Sosial','Pemberitahuan Perubahan Jadwal','Untuk keperluan administrasi akademik, kami membutuhkan data lengkap mengenai...',NULL,'diarsip',0,NULL,8,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(76,'SK-0076/2024','2024-06-18','PT Bank Mandiri','Laporan Rencana Program Tahunan','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'published',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(77,'SK-0077/2025','2025-07-11','Dinas Kesehatan','Surat Pemberitahuan Kegiatan','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'diarsip',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(78,'SK-0078/2024','2024-06-06','Yayasan Pendidikan','Pernyataan Kemitraan Kerjasama','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'diarsip',0,NULL,8,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(79,'SK-0079/2025','2025-12-05','Tim Verifikasi Sekolah','Laporan Hasil Evaluasi','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'draft',0,NULL,3,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(80,'SK-0080/2024','2024-06-14','Panitia Event Kabupaten','Permohonan Magang','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'diarsip',0,NULL,10,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(81,'SK-0081/2025','2025-07-08','Dinas Perindustrian','Permohonan Magang','Berdasarkan evaluasi yang telah dilakukan, kami melaporkan bahwa...',NULL,'draft',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(82,'SK-0082/2024','2024-10-06','Kantor Pajak','Undangan Seminar Pendidik','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'published',0,NULL,9,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(83,'SK-0083/2025','2025-01-17','Kementerian Pendidikan','Surat Pemberitahuan Kegiatan','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'diarsip',0,NULL,9,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(84,'SK-0084/2025','2025-07-13','Komite Orang Tua Peserta Didik','Undangan Seminar Pendidik','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'draft',0,NULL,16,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(85,'SK-0085/2024','2024-08-25','Dinas Perindustrian','Permohonan Donasi untuk Sekolah','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'draft',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(86,'SK-0086/2025','2025-05-06','Kantor Walikota','Permohonan Bantuan Dana','Sesuai dengan surat tugas, peserta didik diharapkan untuk mengikuti kegiatan...',NULL,'published',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(87,'SK-0087/2025','2025-02-28','Organisasi Induk Sekolah','Surat Kepada Orang Tua Siswa','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'diarsip',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(88,'SK-0088/2024','2024-01-11','Yayasan Pendidikan','Sertifikat Penghargaan','Dalam rangka meningkatkan kualitas pendidikan, kami mengajukan kerja sama untuk...',NULL,'published',0,NULL,7,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(89,'SK-0089/2024','2024-02-06','PT Bank Mandiri','Pemberitahuan Perubahan Jadwal','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'diarsip',0,NULL,13,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(90,'SK-0090/2024','2024-11-25','Badan Sosial','Pemberitahuan Perubahan Jadwal','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'draft',0,NULL,14,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(91,'SK-0091/2024','2024-10-08','DPPKB Kabupaten','Undangan Kegiatan Sekolah','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'draft',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(92,'SK-0092/2024','2024-09-01','BNN Kabupaten','Undangan Kegiatan Sekolah','Kami dengan senang hati merekomendasikan siswa-siswi berprestasi untuk mendapat beasiswa...',NULL,'draft',0,NULL,12,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(93,'SK-0093/2024','2024-02-15','BNN Kabupaten','Undangan Seminar Pendidik','Kami dengan hormat mengajukan permohonan kepada Bapak/Ibu...',NULL,'draft',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(94,'SK-0094/2025','2025-05-17','Perusahaan Swasta','Sertifikat Penghargaan','Sesuai dengan surat tugas, peserta didik diharapkan untuk mengikuti kegiatan...',NULL,'draft',0,NULL,16,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(95,'SK-0095/2025','2025-10-12','Kantor Pajak','Permohonan Magang','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'published',0,NULL,4,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(96,'SK-0096/2024','2024-03-17','Dinas Kesehatan','Pengajuan Proposal Kegiatan','Atas dedikasi dan prestasi yang telah dicapai, kami memberikan sertifikat penghargaan...',NULL,'published',0,NULL,3,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(97,'SK-0097/2024','2024-04-05','Badan Sosial','Undangan Kegiatan Sekolah','Dengan ini kami memberitahukan bahwa kegiatan sekolah akan dilaksanakan pada...',NULL,'draft',0,NULL,6,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(98,'SK-0098/2025','2025-04-20','Polres Kabupaten','Rekomendasi Beasiswa','Sehubungan dengan program tahunan sekolah, kami mengundang Bapak/Ibu untuk...',NULL,'published',0,NULL,8,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(99,'SK-0099/2024','2024-03-23','Sekolah Mitra Kerjasama','Surat Tugas Peserta Didik','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'draft',0,NULL,10,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(100,'SK-0100/2024','2024-08-11','Dinas Pendidikan Provinsi','Undangan Kegiatan Sekolah','Kami mohon dukungan dan persetujuan untuk melaksanakan program sebagai berikut...',NULL,'published',0,NULL,10,'2026-01-25 17:51:51','2026-01-25 17:51:51');
/*!40000 ALTER TABLE `surat_keluar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_masuk`
--

DROP TABLE IF EXISTS `surat_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat_masuk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenis_surat` enum('rahasia','penting','biasa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'biasa',
  `kode_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `asal_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perihal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `file_lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','submitted','disposed','received','diarsip') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `kepala_sekolah_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surat_masuk_nomor_surat_unique` (`nomor_surat`),
  KEY `surat_masuk_created_by_foreign` (`created_by`),
  KEY `surat_masuk_kepala_sekolah_id_foreign` (`kepala_sekolah_id`),
  CONSTRAINT `surat_masuk_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `surat_masuk_kepala_sekolah_id_foreign` FOREIGN KEY (`kepala_sekolah_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_masuk`
--

LOCK TABLES `surat_masuk` WRITE;
/*!40000 ALTER TABLE `surat_masuk` DISABLE KEYS */;
INSERT INTO `surat_masuk` VALUES (1,'penting','PI/11/2025','SM-0001/2025','2025-11-13','Universitas Negeri','Pembaruan Data Peserta Didik','Catatan penting surat nomor 1',NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(2,'penting','UM/08/2024','SM-0002/2024','2024-08-24','Universitas Negeri','Pelaksanaan Ujian Nasional',NULL,NULL,'received',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(3,'penting','PI/11/2025','SM-0003/2025','2025-11-04','Dinas Pendidikan Provinsi','Pelaksanaan Ujian Nasional',NULL,NULL,'disposed',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(4,'biasa','SK/08/2025','SM-0004/2025','2025-08-06','BNN Kabupaten','Pelaksanaan Ujian Nasional',NULL,NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(5,'penting','UM/10/2025','SM-0005/2025','2025-10-04','BNN Kabupaten','Pembaruan Data Peserta Didik','Catatan penting surat nomor 5',NULL,'submitted',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(6,'penting','PP/06/2024','SM-0006/2024','2024-06-12','Kantor Pajak','Program Pertukaran Pelajar',NULL,NULL,'submitted',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(7,'penting','UM/08/2025','SM-0007/2025','2025-08-01','Badan Sosial','Pembaruan Data Peserta Didik',NULL,NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(8,'penting','PP/10/2025','SM-0008/2025','2025-10-16','Kementerian Pendidikan','Inspeksi Sekolah','Catatan penting surat nomor 8',NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(9,'rahasia','PI/09/2024','SM-0009/2024','2024-09-07','Perusahaan Swasta','Undangan Seminar Pendidikan',NULL,NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(10,'biasa','UM/07/2024','SM-0010/2024','2024-07-24','Perusahaan Swasta','Pembaruan Data Peserta Didik',NULL,NULL,'received',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(11,'penting','AD/12/2025','SM-0011/2025','2025-12-10','Koperasi Sekolah','Sertifikasi Pendidik',NULL,NULL,'draft',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(12,'biasa','UM/09/2024','SM-0012/2024','2024-09-16','Kementerian Pendidikan','Perubahan Jadwal Pembelajaran',NULL,NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(13,'biasa','SK/09/2024','SM-0013/2024','2024-09-19','Koperasi Sekolah','Laporan Kegiatan Sekolah',NULL,NULL,'submitted',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(14,'biasa','SK/10/2024','SM-0014/2024','2024-10-22','DPPKB Kabupaten','Sertifikasi Pendidik','Catatan penting surat nomor 14',NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(15,'penting','PP/01/2024','SM-0015/2024','2024-01-18','Badan Sosial','Perbaikan Sarana Prasarana','Catatan penting surat nomor 15',NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(16,'biasa','PI/07/2025','SM-0016/2025','2025-07-27','Koperasi Sekolah','Program Pembinaan Siswamandiri',NULL,NULL,'diarsip',1,'2026-01-25 18:39:54',7,2,'2026-01-25 17:51:50','2026-01-25 18:39:54'),(17,'penting','PI/09/2025','SM-0017/2025','2025-09-04','Perusahaan Swasta','Pengumuman Beasiswa',NULL,NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(18,'rahasia','DK/09/2025','SM-0018/2025','2025-09-02','Polres Kabupaten','Sertifikat Penghargaan',NULL,NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(19,'biasa','PP/03/2024','SM-0019/2024','2024-03-10','Kantor Walikota','Program Pertukaran Pelajar','Catatan penting surat nomor 19',NULL,'draft',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(20,'penting','SK/02/2025','SM-0020/2025','2025-02-28','Universitas Negeri','Inspeksi Sekolah',NULL,NULL,'submitted',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(21,'biasa','PI/08/2024','SM-0021/2024','2024-08-25','Dinas Kesehatan','Pembaruan Data Peserta Didik',NULL,NULL,'disposed',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(22,'biasa','DK/04/2024','SM-0022/2024','2024-04-24','Dinas Kesehatan','Pemberitahuan Program Pendidikan',NULL,NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(23,'biasa','DK/11/2025','SM-0023/2025','2025-11-27','PT Bank Mandiri','Program Pertukaran Pelajar',NULL,NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(24,'biasa','SK/06/2025','SM-0024/2025','2025-06-18','Kantor Walikota','Program Pembinaan Siswamandiri','Catatan penting surat nomor 24',NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(25,'biasa','PI/10/2024','SM-0025/2024','2024-10-08','Dinas Perindustrian','Pembaruan Data Peserta Didik',NULL,NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(26,'rahasia','AD/09/2025','SM-0026/2025','2025-09-06','Kantor Pajak','Undangan Seminar Pendidikan',NULL,NULL,'draft',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(27,'penting','UM/08/2024','SM-0027/2024','2024-08-22','DPPKB Kabupaten','Perbaikan Sarana Prasarana','Catatan penting surat nomor 27',NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(28,'penting','UM/02/2024','SM-0028/2024','2024-02-07','Universitas Negeri','Laporan Kegiatan Sekolah','Catatan penting surat nomor 28',NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(29,'biasa','PP/05/2024','SM-0029/2024','2024-05-13','BNN Kabupaten','Pemberitahuan Program Pendidikan','Catatan penting surat nomor 29',NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(30,'biasa','PP/03/2024','SM-0030/2024','2024-03-19','BNN Kabupaten','Program Pertukaran Pelajar',NULL,NULL,'received',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(31,'rahasia','PI/05/2025','SM-0031/2025','2025-05-03','Koperasi Sekolah','Undangan Seminar Pendidikan',NULL,NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(32,'rahasia','PI/11/2024','SM-0032/2024','2024-11-04','Badan Sosial','Audit Keuangan','Catatan penting surat nomor 32',NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(33,'biasa','DK/04/2024','SM-0033/2024','2024-04-21','Kementerian Pendidikan','Renovasi Gedung Sekolah','Catatan penting surat nomor 33',NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(34,'biasa','PP/09/2024','SM-0034/2024','2024-09-17','Kantor Walikota','Laporan Kegiatan Sekolah',NULL,NULL,'draft',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(35,'penting','AD/12/2024','SM-0035/2024','2024-12-24','Kantor Pajak','Surat Ajuan Dana Hibah','Catatan penting surat nomor 35',NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(36,'rahasia','SK/10/2024','SM-0036/2024','2024-10-09','Dinas Pendidikan Provinsi','Audit Keuangan','Catatan penting surat nomor 36',NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(37,'biasa','PI/04/2024','SM-0037/2024','2024-04-25','Perusahaan Swasta','Pengumuman Beasiswa','Catatan penting surat nomor 37',NULL,'received',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(38,'penting','PI/02/2025','SM-0038/2025','2025-02-13','Koperasi Sekolah','Surat Ajuan Dana Hibah',NULL,NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(39,'rahasia','PP/02/2025','SM-0039/2025','2025-02-16','Perusahaan Swasta','Sertifikat Penghargaan','Catatan penting surat nomor 39',NULL,'disposed',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(40,'rahasia','PI/06/2025','SM-0040/2025','2025-06-03','Kementerian Pendidikan','Pembaruan Data Peserta Didik','Catatan penting surat nomor 40',NULL,'submitted',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(41,'biasa','AD/05/2025','SM-0041/2025','2025-05-19','PT Bank Mandiri','Audit Keuangan','Catatan penting surat nomor 41',NULL,'submitted',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(42,'biasa','PP/01/2025','SM-0042/2025','2025-01-13','Dinas Pendidikan Provinsi','Perbaikan Sarana Prasarana',NULL,NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(43,'rahasia','PP/02/2025','SM-0043/2025','2025-02-25','Dinas Kesehatan','Pengumuman Beasiswa',NULL,NULL,'received',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(44,'rahasia','PP/06/2025','SM-0044/2025','2025-06-05','DPPKB Kabupaten','Perubahan Jadwal Pembelajaran',NULL,NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(45,'penting','DK/03/2025','SM-0045/2025','2025-03-06','BNN Kabupaten','Pengumuman Beasiswa',NULL,NULL,'disposed',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(46,'rahasia','SK/01/2024','SM-0046/2024','2024-01-25','Kantor Walikota','Undangan Rapat','Catatan penting surat nomor 46',NULL,'draft',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(47,'biasa','AD/01/2024','SM-0047/2024','2024-01-16','Kantor Pajak','Undangan Rapat','Catatan penting surat nomor 47',NULL,'disposed',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(48,'rahasia','PP/09/2024','SM-0048/2024','2024-09-20','Kantor Walikota','Pengumuman Beasiswa','Catatan penting surat nomor 48',NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(49,'rahasia','UM/04/2025','SM-0049/2025','2025-04-17','Badan Sosial','Permintaan Data Statistik',NULL,NULL,'submitted',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(50,'penting','UM/05/2024','SM-0050/2024','2024-05-27','PT Bank Mandiri','Inspeksi Sekolah',NULL,NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(51,'biasa','UM/03/2024','SM-0051/2024','2024-03-20','Dinas Perindustrian','Laporan Kegiatan Sekolah','Catatan penting surat nomor 51',NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(52,'rahasia','DK/07/2025','SM-0052/2025','2025-07-19','Dinas Pendidikan Provinsi','Undangan Seminar Pendidikan',NULL,NULL,'disposed',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(53,'biasa','SK/01/2024','SM-0053/2024','2024-01-14','BNN Kabupaten','Perbaikan Sarana Prasarana','Catatan penting surat nomor 53',NULL,'disposed',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(54,'biasa','PI/01/2025','SM-0054/2025','2025-01-05','Universitas Negeri','Pengadaan Buku Pelajaran','Catatan penting surat nomor 54',NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(55,'penting','SK/04/2024','SM-0055/2024','2024-04-04','Koperasi Sekolah','Undangan Seminar Pendidikan',NULL,NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(56,'biasa','PP/08/2024','SM-0056/2024','2024-08-05','Koperasi Sekolah','Program Pembinaan Siswamandiri','Catatan penting surat nomor 56',NULL,'submitted',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(57,'biasa','PI/09/2025','SM-0057/2025','2025-09-12','Perusahaan Swasta','Pembaruan Data Peserta Didik','Catatan penting surat nomor 57',NULL,'received',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(58,'penting','PI/12/2025','SM-0058/2025','2025-12-02','PT Bank Mandiri','Inspeksi Sekolah',NULL,NULL,'submitted',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(59,'penting','AD/05/2024','SM-0059/2024','2024-05-12','Universitas Negeri','Perubahan Jadwal Pembelajaran',NULL,NULL,'received',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(60,'biasa','SK/11/2024','SM-0060/2024','2024-11-27','Badan Sosial','Undangan Rapat',NULL,NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(61,'biasa','SK/11/2025','SM-0061/2025','2025-11-23','Kementerian Pendidikan','Sertifikat Penghargaan',NULL,NULL,'submitted',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(62,'biasa','DK/02/2024','SM-0062/2024','2024-02-10','PT Bank Mandiri','Perbaikan Sarana Prasarana',NULL,NULL,'disposed',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(63,'biasa','DK/12/2025','SM-0063/2025','2025-12-08','DPPKB Kabupaten','Audit Keuangan','Catatan penting surat nomor 63',NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(64,'penting','SK/10/2025','SM-0064/2025','2025-10-06','Koperasi Sekolah','Laporan Kegiatan Sekolah','Catatan penting surat nomor 64',NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(65,'rahasia','UM/01/2024','SM-0065/2024','2024-01-12','Koperasi Sekolah','Sertifikasi Pendidik','Catatan penting surat nomor 65',NULL,'received',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(66,'biasa','PP/04/2024','SM-0066/2024','2024-04-06','Dinas Perindustrian','Audit Keuangan',NULL,NULL,'submitted',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(67,'biasa','UM/03/2024','SM-0067/2024','2024-03-19','Yayasan Pendidikan','Surat Ajuan Dana Hibah','Catatan penting surat nomor 67',NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(68,'biasa','SK/07/2024','SM-0068/2024','2024-07-21','Universitas Negeri','Perbaikan Sarana Prasarana','Catatan penting surat nomor 68',NULL,'submitted',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(69,'rahasia','UM/08/2025','SM-0069/2025','2025-08-16','Dinas Perindustrian','Sertifikat Penghargaan','Catatan penting surat nomor 69',NULL,'disposed',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(70,'rahasia','AD/03/2024','SM-0070/2024','2024-03-23','BNN Kabupaten','Kerjasama Program Magang','Catatan penting surat nomor 70',NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(71,'rahasia','PP/10/2024','SM-0071/2024','2024-10-11','Dinas Kesehatan','Pengumuman Beasiswa',NULL,NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(72,'rahasia','DK/12/2025','SM-0072/2025','2025-12-01','Kantor Pajak','Undangan Seminar Pendidikan',NULL,NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(73,'rahasia','PP/03/2024','SM-0073/2024','2024-03-09','Dinas Perindustrian','Pelaksanaan Ujian Nasional','Catatan penting surat nomor 73',NULL,'disposed',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(74,'biasa','UM/06/2024','SM-0074/2024','2024-06-06','Dinas Perindustrian','Sertifikat Penghargaan',NULL,NULL,'submitted',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(75,'biasa','SK/04/2024','SM-0075/2024','2024-04-12','DPPKB Kabupaten','Audit Keuangan','Catatan penting surat nomor 75',NULL,'received',0,NULL,7,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(76,'rahasia','DK/03/2024','SM-0076/2024','2024-03-06','Dinas Perindustrian','Undangan Rapat',NULL,NULL,'submitted',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(77,'biasa','DK/06/2024','SM-0077/2024','2024-06-20','Yayasan Pendidikan','Pengadaan Buku Pelajaran',NULL,NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(78,'penting','DK/03/2025','SM-0078/2025','2025-03-24','Universitas Negeri','Sertifikasi Pendidik',NULL,'surat_masuk/1769397852_Laporan-Surat-Keluar-2026-01-25.pdf','draft',0,NULL,8,2,'2026-01-25 17:51:51','2026-01-25 19:24:12'),(79,'rahasia','DK/03/2025','SM-0079/2025','2025-03-12','Dinas Pendidikan Provinsi','Undangan Seminar Pendidikan','Catatan penting surat nomor 79',NULL,'diarsip',1,'2026-01-25 18:38:45',7,2,'2026-01-25 17:51:51','2026-01-25 18:38:45'),(80,'penting','DK/09/2024','SM-0080/2024','2024-09-05','Universitas Negeri','Renovasi Gedung Sekolah','Catatan penting surat nomor 80',NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(81,'rahasia','SK/01/2024','SM-0081/2024','2024-01-19','Kantor Pajak','Pelaksanaan Ujian Nasional',NULL,NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(82,'penting','UM/09/2025','SM-0082/2025','2025-09-04','Dinas Kesehatan','Audit Keuangan',NULL,NULL,'diarsip',1,'2026-01-25 18:39:02',8,2,'2026-01-25 17:51:51','2026-01-25 18:39:02'),(83,'penting','SK/10/2024','SM-0083/2024','2024-10-15','DPPKB Kabupaten','Perbaikan Sarana Prasarana','Catatan penting surat nomor 83',NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(84,'rahasia','PI/08/2024','SM-0084/2024','2024-08-05','BNN Kabupaten','Sertifikat Penghargaan','Catatan penting surat nomor 84',NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(85,'rahasia','SK/02/2025','SM-0085/2025','2025-02-24','Perusahaan Swasta','Program Pertukaran Pelajar',NULL,NULL,'diarsip',1,'2026-01-25 18:38:56',7,2,'2026-01-25 17:51:51','2026-01-25 18:38:56'),(86,'penting','AD/04/2025','SM-0086/2025','2025-04-09','Dinas Pendidikan Provinsi','Pelaksanaan Ujian Nasional','Catatan penting surat nomor 86',NULL,'diarsip',1,'2026-01-25 18:38:50',8,2,'2026-01-25 17:51:51','2026-01-25 18:38:50'),(87,'biasa','UM/11/2025','SM-0087/2025','2025-11-20','Perusahaan Swasta','Surat Ajuan Dana Hibah','Catatan penting surat nomor 87',NULL,'diarsip',1,'2026-01-25 18:38:40',7,2,'2026-01-25 17:51:51','2026-01-25 18:38:40'),(88,'rahasia','DK/07/2024','SM-0088/2024','2024-07-13','Dinas Kesehatan','Perubahan Jadwal Pembelajaran',NULL,NULL,'diarsip',1,'2026-01-25 18:22:17',7,2,'2026-01-25 17:51:51','2026-01-25 18:22:17'),(89,'biasa','SK/09/2025','SM-0089/2025','2025-09-08','Badan Sosial','Laporan Kegiatan Sekolah','Catatan penting surat nomor 89','surat_masuk/1769396297_Laporan-Surat-Masuk-2026-01-13 (2).pdf','draft',0,NULL,8,2,'2026-01-25 17:51:51','2026-01-25 18:58:17'),(90,'rahasia','PP/06/2025','SM-0090/2025','2025-06-14','Kantor Pajak','Pelaksanaan Ujian Nasional','Catatan penting surat nomor 90',NULL,'draft',0,NULL,7,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(91,'penting','AD/04/2024','SM-0091/2024','2024-04-21','BNN Kabupaten','Program Pembinaan Siswamandiri',NULL,NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(92,'penting','AD/10/2025','SM-0092/2025','2025-10-11','Kementerian Pendidikan','Undangan Seminar Pendidikan','Catatan penting surat nomor 92',NULL,'diarsip',1,'2026-01-25 18:39:09',7,2,'2026-01-25 17:51:51','2026-01-25 18:39:09'),(93,'rahasia','PP/11/2025','SM-0093/2025','2025-11-27','Perusahaan Swasta','Renovasi Gedung Sekolah','Catatan penting surat nomor 93',NULL,'diarsip',1,'2026-01-25 18:39:19',8,2,'2026-01-25 17:51:51','2026-01-25 18:39:19'),(94,'rahasia','UM/02/2024','SM-0094/2024','2024-02-13','Polres Kabupaten','Program Pembinaan Siswamandiri','Catatan penting surat nomor 94',NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(95,'rahasia','AD/02/2025','SM-0095/2025','2025-02-26','DPPKB Kabupaten','Renovasi Gedung Sekolah','Catatan penting surat nomor 95',NULL,'diarsip',1,'2026-01-25 18:39:32',8,2,'2026-01-25 17:51:51','2026-01-25 18:39:32'),(96,'biasa','AD/12/2024','SM-0096/2024','2024-12-20','Polres Kabupaten','Program Pertukaran Pelajar',NULL,NULL,'diarsip',0,NULL,7,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(97,'penting','DK/09/2024','SM-0097/2024','2024-09-28','BNN Kabupaten','Pengadaan Buku Pelajaran',NULL,NULL,'diarsip',1,'2026-01-25 18:39:44',8,2,'2026-01-25 17:51:51','2026-01-25 18:39:44'),(98,'rahasia','PP/06/2025','SM-0098/2025','2025-06-11','Polres Kabupaten','Program Pertukaran Pelajar','Catatan penting surat nomor 98',NULL,'draft',0,NULL,8,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(99,'biasa','DK/05/2025','SM-0099/2025','2025-05-13','Universitas Negeri','Pengumuman Beasiswa',NULL,NULL,'submitted',0,NULL,8,2,'2026-01-25 17:51:51','2026-01-25 17:51:51'),(100,'penting','DK/01/2024','SM-0100/2024','2024-01-18','PT Bank Mandiri','Audit Keuangan',NULL,NULL,'diarsip',0,NULL,8,2,'2026-01-25 17:51:51','2026-01-25 17:51:51');
/*!40000 ALTER TABLE `surat_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tanda_tangan`
--

DROP TABLE IF EXISTS `tanda_tangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tanda_tangan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tanda_tangan_user_id_unique` (`user_id`),
  CONSTRAINT `tanda_tangan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tanda_tangan`
--

LOCK TABLES `tanda_tangan` WRITE;
/*!40000 ALTER TABLE `tanda_tangan` DISABLE KEYS */;
INSERT INTO `tanda_tangan` VALUES (1,2,'tanda_tangan/2_1769398061.png','Ttd Kepsek 1.png','png',2078275,NULL,'2026-01-25 19:27:41','2026-01-25 19:27:41');
/*!40000 ALTER TABLE `tanda_tangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','admin',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(2,'Kepala Sekolah','kepala@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','kepala_sekolah',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(3,'Wakasek Kurikulum','wakasek.kurikulum@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','wakasek_kurikulum',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(4,'Wakasek Sarana Prasarana','wakasek.sarana@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','wakasek_sarana_prasarana',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(5,'Wakasek Kesiswaan','wakasek.kesiswaan@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','wakasek_kesiswaan',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(6,'Wakasek Humas','wakasek.humas@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','wakasek_humas',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(7,'Tata Usaha','tu@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','tu',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(8,'Kepala Tata Usaha','ka.tu@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','ka_tu',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(9,'Kaprog DKV','kaprog.dkv@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','kaprog_dkv',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(10,'Kaprog PPLG','kaprog.pplg@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','kaprog_pplg',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(11,'Kaprog TJKT','kaprog.tjkt@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','kaprog_tjkt',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(12,'Kaprog Bisnis Daring','kaprog.bd@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','kaprog_bd',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(13,'Guru','guru@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','guru',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(14,'Pembina Ekstra','pembina@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','pembina_ekstra',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(15,'Bursa Kerja Khusus','bkk@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','bkk',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50'),(16,'User Biasa','user@esurat.local',NULL,NULL,'$2y$12$Jf0LI4KSOkZv/FRFrDIGYuOFWPNZM11h4fvtHlOVVMhHYLfIpIMii','staff',NULL,'2026-01-25 17:51:50','2026-01-25 17:51:50');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-26 11:57:45
