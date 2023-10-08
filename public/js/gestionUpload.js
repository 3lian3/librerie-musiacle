//on recupère le bouton de chargement

const btnCharger = document.getElementById('chargePochette');
btnCharger.addEventListener('click', lanceParcourir, false);

//on recupère le champs upload
const fileUpload = document.getElementById('album_imageFile');
fileUpload.addEventListener('change', afficheImage, false);

//on recuppère le champs img qui affiche l'image
const imageAffichee = document.getElementById('imageAffichee');

function lanceParcourir() {
    fileUpload.click();
}

function afficheImage () {
    const imageChargee = this.files[0];
    const urlImageChargee = URL.createObjectURL(imageChargee);
    imageAffichee.setAttribute('src', urlImageChargee);
}