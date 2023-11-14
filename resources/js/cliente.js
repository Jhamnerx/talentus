import "./bootstrap";

import Swal from "sweetalert2";

window.Swal = Swal;
import iziToast from "izitoast";
window.iziToast = iziToast;

import DataTable from "datatables.net-dt";
import Sortable from "sortablejs";
window.DataTable = DataTable;

import DecoupledEditor from "@ckeditor/ckeditor5-build-decoupled-document";

window.DecoupledEditor = DecoupledEditor;
