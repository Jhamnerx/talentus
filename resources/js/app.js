import "./bootstrap";
import "./main";
import "./utils";
import "./slider";

import VenoBox from "venobox";

window.VenoBox = VenoBox;

new VenoBox({
    selector: ".image-task",
    maxWidth: "75%",
    spinner: "rotating-plane",
});
// import Sortable from "sortablejs";

// window.Sortable = Sortable;

//Sortable.start();

//import Sortable from "sortablejs";

import Swal from "sweetalert2";

window.Swal = Swal;
import iziToast from "izitoast";
window.iziToast = iziToast;

//FILE POND IMAGE DROP AND DRAG
import * as FilePond from "filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

FilePond.registerPlugin(FilePondPluginImagePreview);

window.FilePond = FilePond;

// import DecoupledEditor from "@ckeditor/ckeditor5-build-decoupled-document";
// window.DecoupledEditor = DecoupledEditor;
// import Base64UploadAdapter from "@ckeditor/ckeditor5-upload/src/adapters/base64uploadadapter";

// // DecoupledEditor.builtinPlugins = [Base64UploadAdapter];
