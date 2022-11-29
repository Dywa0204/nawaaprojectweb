//Membuat event listener berupa click pada element dengan id = "order_file_button"
document.getElementById("order_file_button").addEventListener('click', () => {
    //Saat element dengan id "order_file_button" diklik akan melakukan perintah berupa klik element dengan id = "order_file"
    //Element "order_file" disini adalah sebuah input bertipe file
    document.getElementById("order_file").click();
})

//Membuat event listener berupa change pada element dengan id = "order_file"
//Element "order_file" disini adalah sebuah input bertipe file
//Jika input memiliki perubahan value maka fungsi akan berjalan
document.getElementById("order_file").addEventListener('change', event => {
    let file = event.target.files[0]; //file target, berisi informasi dari file

    //Cek jika file bertipe bukan tipe gambar(image)
    if(file.type.includes('image') == false){
        //Maka akan keluar pesan "File harus bertipe gambar" dan value input file akan dikosongkan
        document.getElementById("order_column_file_info").innerHTML = "File harus bertipe gambar";
        document.getElementById("order_file").value = null;
    }
    //Cek jika ukuran file lebih dari 15MB
    else if(file.size >= 15000000){
        //Maka akan keluar pesan "Ukuran file harus kurang dari 15MB" dan value input file akan dikosongkan
        document.getElementById("order_column_file_info").innerHTML = "Ukuran file harus kurang dari 15MB";
        document.getElementById("order_file").value = null;
    }
    //Jika tidak ada
    else{
        //Maka akan keluar pesan berupa nama file beserta ekstensinya 
        document.getElementById("order_column_file_info").innerHTML = event.target.files[0].name;
    }
})

//Membuat event listener berupa change pada element (button) dengan id = "order_column_submit"
document.getElementById("order_column_submit").addEventListener('click', () => {
    //Akan di cek apakah value pada input file kosong atau tidak
    if(document.getElementById("order_file").files.length == 0){
        //Kalau value input file kosong atau tidak ada file yang dipilih maka akan keluaar pesan "File tidak boleh kosong"
        document.getElementById("order_column_file_info").innerHTML = "File tidak boleh kosong";
    }
})