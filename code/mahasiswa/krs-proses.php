<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'mahasiswa') {
    header("Location: ../loginpage.php");
    exit();
}
$mahasiswa = get_mahasiswa_from_id_user($_SESSION['user']['ID_User']);
$nim = $mahasiswa['NIM'];
$selected_courses = $_POST['matakuliah'] ?? [];

$krs_success = [];
$krs_failure = [];

foreach ($selected_courses as $course_id) {

    $query = "SELECT Kuota_Matakuliah_KRS FROM Matakuliah_KRS WHERE ID_Matakuliah_KRS = '$course_id'";
    $result = mysqli_query(DB, $query);
    $data = mysqli_fetch_assoc($result);
    echo $data;

    if ($data["Kuota_Matakuliah_KRS"]> 0) {
        $update_query = "UPDATE Matakuliah_KRS SET Kuota_Matakuliah_KRS = Kuota_Matakuliah_KRS - 1 WHERE ID_Matakuliah_KRS = '$course_id'";
        mysqli_query(DB, $update_query);

        $semester = $_SESSION['user']['SEMESTER_Mahasiswa'];
        $insert_krs_query = "INSERT INTO KRS (Semester, NIM) VALUES ('$semester', '$nim')";
        mysqli_query(DB, $insert_krs_query);

        $krs_id = mysqli_insert_id(DB);

        $insert_krs_detail_query = "INSERT INTO KRS_Detail (ID_Matakuliah_KRS, ID_KRS) VALUES ('$course_id', '$krs_id')";
        mysqli_query(DB, $insert_krs_detail_query);
        $krs_success[] = $course_id;
    } else {
        $krs_failure[] = $course_id;
    }
}

// Simpan hasil ke session
$_SESSION['krs_success'] = $krs_success;
$_SESSION['krs_failure'] = $krs_failure;

// Redirect ke halaman hasil KRS
header("Location: krs-succed.php");
exit();
?>
