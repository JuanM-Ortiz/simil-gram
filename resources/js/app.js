import './bootstrap';
import '../css/app.css'; 

import Dropzone from "dropzone";
Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone',{
    dictDefaultMessage: 'Sube tu imagen aqui',
    acceptedFiles: ".png , .jpg , .jpeg , .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        if(document.querySelector('[name="image"]').value.trim()) {
            const imagePub = {}
            imagePub.size = 1234;
            imagePub.name = document.querySelector('[name="image"]').value;

            this.options.addedfile.call( this, imagePub );

            this.options.thumbnail.call(this, imagePub, `/uploads/${imagePub.name}`);

            imagePub.previewElement.classList.add('dz-success', 'dz-complete');
        }
    }
});

dropzone.on('success', function(file, response){
    document.querySelector('[name="image"]').value = response.image;
});

dropzone.on("removedfile", function(){
    document.querySelector('[name="image"]').value = "";
});

