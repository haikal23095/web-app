<?php
include_once('config.php');

date_default_timezone_set("Asia/Jakarta");

function get_all_data_dosen(){
    $query = "SELECT
        Dosen.NIP,
        Dosen.Nama_Dosen,
        Prodi.Nama_Prodi,
        Dosen.Alamat_Dosen,
        Dosen.Jenis_Kelamin_Dosen
    FROM Dosen
    LEFT JOIN Prodi ON Prodi.ID_Prodi = Dosen.ID_Prodi";
    return mysqli_query (DB,$query)->fetch_all(MYSQLI_ASSOC);     
}

function get_data_dosen($id_user){
    $query = 'SELECT 
        d.NIP, 
        d.Nama_Dosen, 
        u.Username,
        u.ID_User
    FROM Dosen d
    LEFT JOIN User u ON d.ID_User = u.ID_User
    WHERE u.ID_User = ?';

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function get_matakuliah_diampu($nip){
    $query = "SELECT 
                mkrs.ID_Matakuliah_KRS, 
                mkrs.Nama_Matakuliah_KRS, 
                mk.Bobot_SKS,
                r.Nama_Ruangan
                FROM Matakuliah_KRS mkrs
                LEFT JOIN Matakuliah mk ON mkrs.ID_Matakuliah = mk.ID_Matakuliah
                LEFT JOIN Dosen d ON mkrs.NIP = d.NIP
                LEFT JOIN Ruangan r ON mkrs.ID_Ruangan = r.ID_Ruangan
                WHERE d.NIP = ?";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $nip);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function get_mahasiswa_from_id_user($id_user){
    $query = "SELECT * FROM Mahasiswa WHERE ID_User = ?";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function get_dosen_from_id_user($id_user){
    $query = "SELECT * FROM Dosen WHERE ID_User = ?";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function get_prodi_from_ID_Prodi($nama_prodi){
    $query = "SELECT * FROM Prodi WHERE ID_Prodi = ?";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $nama_prodi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function get_transkrip_nilai($nim){
    $query = "SELECT Matakuliah.Semester_Matakuliah, Matakuliah.Kode_Matakuliah, Matakuliah.Nama_Matakuliah, Matakuliah.SKS_Matakuliah, KHS_Detail.Nilai
                FROM Matakuliah
                JOIN Transkip_nilai ON Transkip_nilai.ID_Matakuliah = Matakuliah.ID_Matakuliah  
                JOIN KHS_Detail ON KHS_Detail.ID_Matakuliah = Matakuliah.ID_Matakuliah
                WHERE Transkip_nilai.NIM = ?";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $nim);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
    
}

function get_sks_total_transkrip($nim){
    $query = "SELECT SUM(Matakuliah.SKS_Matakuliah) as TotalSKS
                FROM Matakuliah
                JOIN Transkip_nilai ON Transkip_nilai.ID_Matakuliah = Matakuliah.ID_Matakuliah  
                WHERE Transkip_nilai.NIM = ?";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $nim);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function get_matakuliah_total_transkrip($nim){
    $query = "SELECT COUNT(ID_Matakuliah) as TotalMatakuliah FROM Transkip_nilai WHERE NIM = ?";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $nim);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function get_ipk($nim){
    $query = "SELECT SUM(Nilai * SKS_Matakuliah) as TotalNilai, SUM(SKS_Matakuliah) as TotalSKS 
                FROM Matakuliah 
                JOIN Transkip_nilai ON Transkip_nilai.ID_Matakuliah = Matakuliah.ID_Matakuliah
                JOIN KHS_Detail ON KHS_Detail.ID_Matakuliah = Matakuliah.ID_Matakuliah
                WHERE NIM = ?";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $nim);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    // echo $data['TotalNilai']."<br>";
    // echo $data['TotalSKS']."<br>";
    return number_format($data['TotalNilai'] / $data['TotalSKS'], 2);
}

function get_data_matkul_krs() {
    // Define the SQL query
    $query = "SELECT 
        m.Kode_Matakuliah, 
        m.Nama_Matakuliah, 
        m.SKS_Matakuliah,
        m.Semester_Matakuliah
    FROM Matakuliah m";

    // Execute the query
    $result = mysqli_query(DB, $query);

    // Check for query execution errors
    if (!$result) {
        // Log the error or handle it as needed
        error_log("Database query failed: " . mysqli_error(DB));
        return []; // Return an empty array on failure
    }

    // Fetch all results as an associative array
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_file_kalender($file) {
    
        // Cek apakah file diupload
        if (isset($file['kalender']) && $file['kalender']['error'] == 0) {
            $fileTmpPath = $file['kalender']['tmp_name'];
            $fileName = $file['kalender']['name'];
            $fileSize = $file['kalender']['size'];
            $fileType = $file['kalender']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            // Validasi ekstensi file
            if ($fileExtension === 'pdf') {
                // Validasi tipe MIME
                if ($fileType === 'application/pdf') {
                    // Tentukan lokasi untuk menyimpan file
                    $uploadFileDir = './';
                    $dest_path = $uploadFileDir . $fileName;
    
                    // Pindahkan file ke direktori tujuan
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        echo 'File berhasil diupload.';
                        $now = date("Y-m-d");
                        mysqli_query(DB,"INSERT INTO Kalender values(null, '$fileName', '$now')");
                    } else {
                        echo 'Terjadi kesalahan saat mengupload file.';
                    }
                } else {
                    echo 'Tipe file tidak valid. Harus berupa PDF.';
                }
            } else {
                echo 'Ekstensi file tidak valid. Harus berupa PDF.';
            }
        }
    }

function get_nama_kalender() {
    $result= mysqli_query(DB, 'SELECT * FROM Kalender');
    return $result;
}

function get_program_studi() {
    $result = mysqli_query(DB, 'SELECT * FROM Prodi');
    return $result;
}

function get_matakuliah($semester, $id_prodi) {
    $query = 'SELECT * FROM Matakuliah WHERE Semester_Matakuliah = ? AND ID_Prodi = ?';
    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $semester, $id_prodi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $result;
}

function get_all_pesan_masuk($id_user) {
    $query = "SELECT * FROM Pesan_Masuk WHERE ID_User = ? ";
    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_user);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function get_all_pesan_terkirim($id_user) {
    $query = "SELECT * FROM Pesan_Terkirim WHERE ID_User = ? ";
    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_user);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function get_krs_mahasiswa($nim, $semester) {
    $query = "SELECT 
    KRS.ID_KRS, 
    KRS_Detail.ID_Matakuliah_KRS, 
    Matakuliah_KRS.ID_Matakuliah, 
    Matakuliah.Kode_Matakuliah, 
    Matakuliah.Nama_Matakuliah, 
    Matakuliah.SKS_Matakuliah
FROM 
    KRS 
JOIN 
    KRS_Detail ON KRS.ID_KRS = KRS_Detail.ID_KRS 
JOIN 
    Mahasiswa ON KRS.NIM = Mahasiswa.NIM 
JOIN 
    Matakuliah_KRS ON KRS_Detail.ID_Matakuliah_KRS = Matakuliah_KRS.ID_Matakuliah_KRS 
JOIN 
    Matakuliah ON Matakuliah_KRS.ID_Matakuliah = Matakuliah.ID_Matakuliah
WHERE 
    Mahasiswa.NIM = ? AND KRS.Semester_KRS = ?
";
    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 'si', $nim, $semester);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function get_khs_mahasiswa($nim){
    $query = "SELECT * FROM KHS JOIN Mahasiswa ON KHS.NIM = Mahasiswa.NIM JOIN KHS_Detail ON KHS.ID_KHS = KHS_DETAIL.ID_KHS JOIN Matakuliah_KRS ON Matakuliah_KRS.ID_Matakuliah_KRS = Matakuliah_KRS.ID_Matakuliah_KRS WHERE NIM = ?";
    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $nim);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function get_prodi_mahasiswa($nim){
    $query = "SELECT * FROM Mahasiswa JOIN Prodi ON Mahasiswa.ID_Prodi = Prodi.ID_Prodi WHERE NIM = ?";
    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $nim);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function get_ip_semester($nim){
    $query = "SELECT IP_Semester FROM KHS WHERE NIM = ? AND Semester_KHS = (SELECT MAX(Semester_KHS) FROM KHS WHERE NIM = ?)";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $nim, $nim);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
    
}

function get_dosen_wali($nim){
    $query = "SELECT * FROM Dosen JOIN Mahasiswa_Perwalian ON Dosen.NIP = Mahasiswa_Perwalian.NIP WHERE Mahasiswa_Perwalian.NIM = ?";

    $stmt = mysqli_prepare(DB, $query);
    mysqli_stmt_bind_param($stmt, 's', $nim);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function delete_krs_matakuliah($nim, $semester) {
    $query = "DELETE FROM KRS WHERE NIM = ? AND SEMESTER_KRS = ?";
    $stmt = DB->prepare($query);
    $stmt->bind_param("ii", $nim, $semester);
    $stmt->execute();
    $stmt->close();
}

function delete_krs_detail($id_krs,$id_matakuliah_krs) {
    $query = "DELETE FROM KRS_Detail WHERE ID_KRS = ? AND ID_Matakuliah_KRS = ?";
    $stmt = DB->prepare($query);
    $stmt->bind_param("is", $id_krs, $id_matakuliah_krs);
    $stmt->execute();
    $stmt->close();
}

function get_krs_id($nim, $semester) {
    $query = "SELECT ID_KRS FROM KRS WHERE NIM = ? AND SEMESTER_KRS = ?";
    $stmt = DB->prepare($query);
    $stmt->bind_param("ii", $nim, $semester);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

function delete_data_dosen($nip) {
    $query = "DELETE FROM Dosen WHERE NIP = ?";
    $stmt = DB->prepare($query);
    $stmt->bind_param("i", $nip);
    $stmt->execute();
    $stmt->close();
}

function get_all_data_mahasiswa(){
    $query = "SELECT
        Mahasiswa.NIM,
        Mahasiswa.Nama_Mahasiswa,
        Prodi.Nama_Prodi,
        Mahasiswa.Alamat_Mahasiswa,
        Mahasiswa.Jenis_Kelamin_Mahasiswa,  
        Mahasiswa.SEMESTER_Mahasiswa
    FROM Mahasiswa
    LEFT JOIN Prodi ON Prodi.ID_Prodi = Mahasiswa.ID_Prodi
    LEFT JOIN Mahasiswa_Perwalian ON Mahasiswa_Perwalian.ID_Mahasiswa_Perwalian = Mahasiswa.ID_Mahasiswa_Perwalian
    LEFT JOIN UKT_Mahasiswa ON UKT_Mahasiswa.ID_UKT = Mahasiswa.ID_UKT";

    return mysqli_query (DB,$query)->fetch_all(MYSQLI_ASSOC);
}
?>