import "./bootstrap";
import "./soft-ui-dashboard";
import "./fontawesome.js";
import IconPicker from "./icon-picker.js";
import Sortable from 'sortablejs';
// import 'jquery.repeater'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Chart from 'chart.js/auto';


window.IconPicker = IconPicker;
window.Sortable = Sortable;

ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
