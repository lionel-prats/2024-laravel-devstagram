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
const myDropzone = new Dropzone("#dropzone", {
   dictDefaultMessage: "Sube aquí tu imagen", 
   acceptedFiles: ".png,.jpg,.jpeg,.gif", 
   addRemoveLinks: true,
   dictRemoveFile: "Borrar Archivo",
   maxFiles: 1,
   uploadMultiple: false,
});