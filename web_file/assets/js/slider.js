let sliderIndex = 1; //Angka untuk menampilkan slider pada urutan ke berapa

//Memilih element berupa element span
document.querySelectorAll('span').forEach(item => {
    //Membuat event listener berupa click pada setiap element span yang dipilih
    item.addEventListener('click', event => {
        //Jika element span yang diklik memiliki id = "slider_prev" maka 
        //akan memanggil fungsi sliderAddIndex dengan parameter false (angka dikurangi)
        if(event.target.id == 'slider_prev') sliderAddIndex(false);
        
        //Jika element span yang diklik memiliki id = "slider_next" maka 
        //akan memanggil fungsi sliderAddIndex dengan parameter true (angka ditambah)
        else if(event.target.id == 'slider_next') sliderAddIndex(true);

        //Jika element span yang diklik memiliki id yang mengandung kata "bullet" maka
        //akan memanggil fungsi changeSliderImage dengan parameter angka yang ada di id element tersebut
        else if(event.target.id.includes('bullet')){
            let index = parseInt(event.target.id.replace(/bullet_/g, ''));
            sliderIndex = index;
            changeSliderImage(index);
        }
    })
})

//Fungsi untuk mengganti slider setiap 5 detik
function slider5Second(){
    //Mengatur waktu delai selama 5 detik
    setTimeout(() => {
        sliderAddIndex(true); //memanggil fungsi sliderAddIndex dengan parameter true (angka ditambah)
        slider5Second(); //Rekursif -> akan berulang terus menerus setiap 5 detik
    }, 5000);
}slider5Second(); //Panggil fungsi saat pertama kali data loaded

//Fungsi untuk menambah atau mengurangi angka slider sesuai parameternya
function sliderAddIndex(isAdd){
    //Jika parameter true, maka angka ditambah namun jika angka sudah 3 maka akan ulang ke 1 lagi
    if(isAdd){
        if(sliderIndex == 3) sliderIndex = 1;
        else sliderIndex += 1;
    }
    
    //Jika parameter false, maka angka dikurangi namun jika angka sudah 1 maka akan ulang ke 3 lagi
    else{
        if(sliderIndex == 1) sliderIndex = 3;
        else sliderIndex -= 1;
    }

    //Panggil fungsi changeSliderImage dengan parameter angka slider nya untuk mengganti tampilan slider
    changeSliderImage(sliderIndex);
}

//Fungsi untuk mengganti tampilan slider sesuai angka slidernya
function changeSliderImage(index){
    //Mengganti source gambar pada slider sesuai angka slidernya
    document.getElementById('slider_image').src = "./assets/images/slide-0" + index + ".png";
    
    //Mengganti posisi bullet
    for(let i = 1; i <= 3; i++){
        if(i == index) document.getElementById('bullet_' + i).setAttribute('class', 'bullets bullets_active');
        else document.getElementById('bullet_' + i).setAttribute('class', 'bullets');
    }
}