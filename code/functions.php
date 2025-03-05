<?php
function checklogin($data, &$errors){
    $username = $data["username"];
    $password = $data["password"];

    $result = mysqli_query(DB, "SELECT * FROM User WHERE username = '$username' AND password = SHA2('$password', 256) ");

    if (mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $user;
        $_SESSION['Level'] = $user['Level'];
        
        if ($user['Level'] == 'admin'){
            return header("Location: admin/index.php");
        }elseif($user['Level'] == 'dosen'){
            return header("Location: dosen/index.php");
        }else{
            return header("Location: mahasiswa/index.php");
        }
    }else{
        $errors[] = "Username atau password salah";
        return;
    }
}

function max_sks_diambil($ip_semester){
    if ($ip_semester >= 3.5){
        return 24;
    }elseif($ip_semester >= 3.0){
        return 21;
    }elseif($ip_semester >= 2.5){
        return 18;
    }elseif($ip_semester >= 2.0){
        return 15;
    }elseif($ip_semester >= 1.5){
        return 12;
    }elseif($ip_semester >= 1.0){
        return 9;
    }else{
        return 6;
    }
}

function konversi_nilai($huruf) {
    if ($huruf == "A"){
        return 4;
    }elseif($huruf == "B+"){
        return 3.5;
    }elseif($huruf == "B"){
        return 3;
    }elseif($huruf == "C+"){
        return 2.5;
    }elseif($huruf == "C"){
        return 2;
    }elseif($huruf == "D+"){
        return 1.5;
    }elseif($huruf == "D"){
        return 1;
    }else{
        return 0;
    }
}