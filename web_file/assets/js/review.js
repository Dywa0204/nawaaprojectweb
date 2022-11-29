
//Memilih element berupa element i
document.querySelectorAll('i').forEach(item => {
    //Membuat event listener berupa click pada setiap element i yang dipilih
    item.addEventListener('click', event => {
        //Mendapatkan angka untuk disimpan pada value input
        number = parseInt(event.target.id.replace(/detail_info_rating_/g, ''));

        //Dilakukan perulangan untuk mengubah warna bintang pada rating
        for(let i = 1; i <= 5; i++){
            let detail_info_rating = document.getElementById('detail_info_rating_' + i)

            //Saat salah satu elemen i diklik dan iterasi perulangan kurang dari angka
            //Maka bintang pada elemen i tersebut dan elemen i sebelumnya akan berwarna kuning
            //(diubah attribut class-nya / diubah style-nya)
            if(i <= number){
                detail_info_rating.setAttribute('class', 'fas fa-star star_active');
            }else{
                detail_info_rating.setAttribute('class', 'fas fa-star');
            }
        }
        //Mencetak angka rating
        document.getElementById('detail_info_rating').innerHTML = number + '.0';

        //Memasukkan nilai angka ke value input
        document.getElementById('review_rating').value = number;
    })
})