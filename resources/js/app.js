require("./bootstrap");
require("./main");
require("./utils");
require("./slider");

import Alpine from "alpinejs";

window.Alpine = Alpine;

import mask from "@alpinejs/mask";

Alpine.plugin(mask);

Alpine.start();

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

import DataTable from "datatables.net-dt";
import Sortable from "sortablejs";
window.DataTable = DataTable;

import DecoupledEditor from "@ckeditor/ckeditor5-build-decoupled-document";

window.DecoupledEditor = DecoupledEditor;
