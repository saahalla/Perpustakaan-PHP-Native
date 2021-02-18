<?php
    $post = file_get_contents("php://input");
    $json = [];
    $json = json_decode($post, true);

    function queryData($query){
        include "config2.php";
        $result = mysqli_query($mysqli, $query);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    function queryGetData($query){
        include "config2.php";
        $result = mysqli_query($mysqli, $query);
        $array = [];
        if(mysqli_num_rows($result) > 0){
            $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return $array;
    }

    function deleteData($dbname, $id){
        include "config2.php";
        $query = "DELETE FROM $dbname WHERE id='$id'";
        // echo $query;
        $result = mysqli_query($mysqli, $query);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    function getAllData($dbname){
        include "config2.php";
        $query = "SELECT * FROM $dbname ORDER BY id DESC";
        $result = mysqli_query($mysqli, $query);

        $array = [];
        if(mysqli_num_rows($result) > 0){
            $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return $array;

    }

    function getDataById($dbname, $id){
        include "config2.php";
        $query = "SELECT * FROM $dbname WHERE id=$id";
        $result = mysqli_query($mysqli, $query);

        $array = [];
        if(mysqli_num_rows($result) > 0){
            $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return $array;

    }

    if($json["accessToken"]=="16022021-saahalla"){
        if($json["action"]=="login"){
            $username = $json["username"];
            $password = $json["password"];
            $query = "SELECT * FROM users WHERE username='$username' OR email='$username'";
            $array = queryGetData($query);
            
            if(count($array)>0){
                $user_data = $array[0];

                if(password_verify($password, $user_data["password"])){
                    $result["isSuccess"] = true;
                    $result["message"] = "login success";
                    $result["data"] = $user_data;
                    
                }else{
                    $old_username = $user_data["username"];
                    
                    $result["isSuccess"] = false;
                    $result["message"] = "wrong password";
                    $result["last_username"] = $old_username;
                    $result["json"] = $json;
                }

                // echo json_encode($user_data);
            }else{
                $result["isSuccess"] = false;
                $result["message"] = "user not found";
                $result["json"] = $json;
            }
        } elseif ($json["action"]=="register"){
            $username = $json["username"];
            $name = $json["name"];
            $email = $json["email"];
            $role = $json["role"];
            $password = $json["password"];
            
            $query = "INSERT INTO users (name, username, email, password, roles) 
            VALUES ('$name', '$username', '$email', '$password', '$role')";
    
            $register = queryData($query);
            
            if($register){
                $result["isSuccess"] = true;
            }
        } elseif ($json["action"]=="getAllData"){
            $dbname = $json["data"];
            $array = getAllData($dbname);

            if($array){
                $result["isSuccess"] = true;
                $result["data"] = $array;
            }else{
                $result["isSuccess"] = false;
                $result["message"] = "error get data buku";
            }
        } elseif ($json["action"]=="getDataBukuById"){
            $dbname = $json["data"];
            $id = $json["id"];
            $array = getDataById($dbname, $id);

            if($array){
                $result["isSuccess"] = true;
                $result["data"] = $array;
            }else{
                $result["isSuccess"] = false;
                $result["message"] = "error get data by id";
            }
        } elseif ($json["action"]=="addBuku"){
            $judul = $json["judul"];
            $pengarang = $json["pengarang"];
            $jenis = $json["jenis"];
            $penerbit = $json["penerbit"];
            $tahun = $json["tahun"];
            $image = $json["image"];
            $timestamp = $json["timestamp"];
        
            $query = "INSERT INTO buku(judul_buku, pengarang, jenis_buku, tahun_terbit, penerbit, creation_date, image) VALUES('$judul', '$pengarang', '$jenis', '$tahun', '$penerbit', '$timestamp', '$image')";
            $array = queryData($query);

            if($array){
                $result["isSuccess"] = true;
                $result["message"] = "add data success";
            }else{
                $result["isSuccess"] = false;
                $result["message"] = "error add data";
            }
        } elseif ($json["action"]=="editBuku"){
            $id = $json["id"];
            $judul = $json["judul"];
            $pengarang = $json["pengarang"];
            $jenis = $json["jenis"];
            $penerbit = $json["penerbit"];
            $tahun = $json["tahun"];
            $image = $json["image"];
            $update_at = $json["updat$update_at"];

            $query = "UPDATE buku SET judul_buku = '$judul', pengarang = '$pengarang', jenis_buku = '$jenis', tahun_terbit = '$tahun', penerbit = '$penerbit', image = '$image', update_at = '$update_at' WHERE id='$id'";
            
            $array = queryData($query);

            if($array){
                $result["isSuccess"] = true;
                $result["message"] = "edit data success";
            }else{
                $result["isSuccess"] = false;
                $result["message"] = "error edit data";
            }
        } elseif ($json["action"]=="deleteBuku"){
            $id = $json["id"];
            $dbname = $json["data"];

            $delete = deleteData($dbname, $id);

            if($delete){
                $result["isSuccess"] = true;
                $result["message"] = "delete data success";
            }else{
                $result["isSuccess"] = false;
                $result["message"] = "error delete data";
            }
        } elseif ($json["action"]=="getDataPinjam"){
            $role = $json["role"];
            if($role == "admin"){
                $query =    "SELECT meminjam.id, meminjam.jumlah_pinjam, meminjam.tgl_pinjam, meminjam.tgl_kembali, meminjam.kembali, users.name, buku.judul_buku FROM meminjam JOIN users ON users.id = meminjam.id_user JOIN buku ON buku.id = meminjam.id_book ORDER BY id DESC";
            }else{
                $username = $json["username"];
                $query =    "SELECT meminjam.id, meminjam.jumlah_pinjam, meminjam.tgl_pinjam, meminjam.tgl_kembali, meminjam.kembali, users.name, buku.judul_buku FROM meminjam JOIN users ON users.id = meminjam.id_user JOIN buku ON buku.id = meminjam.id_book WHERE users.username='$username' ORDER BY id DESC";
            }
          
            $array = queryGetData($query);
            if($array){
                $result["isSuccess"] = true;
                $result["message"] = "get data success";
                $result["data"] = $array;
            }else{
                $result["isSuccess"] = false;
                $result["message"] = "error get data";
            }
        } elseif ($json["action"]=="addDataPinjam"){
            $date = $json["date"];
            $id = $json["id"];
            $id_user = $json["id_user"];
            $query = "INSERT INTO meminjam(tgl_pinjam, jumlah_pinjam, id_book, id_user, kembali) VALUES('$date', '1', '$id', '$id_user', 0)";
            
            queryData($query);
        } elseif ($json["action"]=="updateDataPinjam"){
            $id = $json["id"];
            $date_kembali = $json["date_kembali"];

            $query =    "UPDATE meminjam SET tgl_kembali = '$date_kembali', kembali = 1 where id='$id'";
            $array  = queryData($query);
            if($array){
                $result["isSuccess"] = true;
                $result["message"] = "update data success";
            }else{
                $result["isSuccess"] = false;
                $result["message"] = "error update data";
            }
            // $result["tes"] = "ok";

        }
    }else{
        $result["isSuccess"] = false;
        $result["message"] = "error1";
        $result["json"] = $json;
    }
    echo json_encode($result);
?>
