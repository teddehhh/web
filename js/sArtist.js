var pic1 = "images/artists/rise.jpg";
var pic2 = "images/artists/halsey.jpg";
var t;

async function ChangeArtistImg(pic){
    document.images["artist"].src = pic;
    await new Promise(resolve => setTimeout(resolve, 5000));
    if (pic == pic1)
        ChangeArtistImg(pic2)
    else
        ChangeArtistImg(pic1);
}

window.onload = () =>{
    ChangeArtistImg(pic2);
}