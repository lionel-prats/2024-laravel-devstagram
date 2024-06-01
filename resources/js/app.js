// import './bootstrap';

/*
// configuracion original Dropzone segun configuracion (Video 93) vvv 

// If you are using JavaScript/ECMAScript modules:
import Dropzone from "dropzone";

// If you are using CommonJS modules:
const { Dropzone } = require("dropzone");

// If you are using an older version than Dropzone 6.0.0,
// then you need to disabled the autoDiscover behaviour here:
Dropzone.autoDiscover = false;

let myDropzone = new Dropzone("#my-form");
myDropzone.on("addedfile", file => {
  console.log(`File added: ${file.name}`);
});

// documentacion -> https://docs.dropzone.dev/getting-started/installation/npm-or-yarn
*/ 

// configuracion libreria Dropzone (Video 93)
import Dropzone from "dropzone";
Dropzone.autoDiscover = false;
// const myDropzone = new Dropzone("#dropzone", {
const dropzone = new Dropzone("#dropzone", {
   dictDefaultMessage: "Sube aquí tu imagen", 
   acceptedFiles: ".png,.jpg,.jpeg,.gif", 
   addRemoveLinks: true,
   dictRemoveFile: "Borrar Imagen",
   maxFiles: 1,
   uploadMultiple: false,

   init: function(){

    if(document.querySelector("[name='imagen']").value.trim()) {

      const imagenPublicada = {};
      imagenPublicada.size = 1234;
      imagenPublicada.name = document.querySelector("[name='imagen']").value;

      this.options.addedfile.call(this, imagenPublicada);

      // accedo a la imagen ya guardada en el server para renderizarla en el form #dropzone 
      // esto es posible porque estamos almacenando las imagenes dentro de /public, y el navegador tiene acceso al contenido de esta carpeta (v105)
      this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

      // agrego clases de dropzone
      imagenPublicada.previewElement.classList.add("dz-success", "dz-complete");
    }

   }
});

// evento que se ejecuta en el cliente cuando realizamos la peticion AJAX al server
/* dropzone.on("sending", function(file, xhr, formData) {
  console.clear();
  console.log(formData);
  console.log("Ejecucion del evento 'sending' de Dropzone, desde resources/js/app.js");
  console.log("Este evento se ejecuta cuando se realiza la peticion al server\n\n");
}) */

// evento que se ejecuta en el cliente cuando la peticion AJAX es exitosa y obtenemos respuesta del server
dropzone.on("success", function(file, response){
  // console.clear();
  // console.log("Ejecucion del evento 'success' de Dropzone, desde resources/js/app.js");
  // console.log("Este evento se ejecuta cuando la respuesta del server es exitosa");
  // console.log("Respuesta del server vvv");
  // console.log(response.imagen);
  document.querySelector("[name='imagen']").value = response.imagen; // (v104)
})

// evento que se ejecuta en el cliente cuando la peticion AJAX falla
dropzone.on("error", function(file, message){
  console.log(message);
  console.log("Ejecucion del evento 'error' de Dropzone, desde resources/js/app.js");
  console.log("Este evento se ejecuta cuando la respuesta del server falla\n\n");
})

// evento que se ejecuta en el cliente cuando desde la vista eliminamos un archivo previamente cargado en el form #dropzone 
dropzone.on("removedfile", function(){
  // console.clear();
  // console.log("Ejecucion del evento 'removedfile' de Dropzone, desde resources/js/app.js");
  // console.log("Este evento se ejecuta cuando desde el form #dropzone en el cliente eliminamos el archivo previamente cargado\n\n");\
  document.querySelector("[name='imagen']").value = ""; // (v106)
})