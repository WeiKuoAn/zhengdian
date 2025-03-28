/*
Template Name: Ubold - Responsive Bootstrap 5 Admin Dashboard
Author: CoderThemes
Website: https://coderthemes.com/
Contact: support@coderthemes.com
File: X-editable init js
*/
//
import moment from "moment";
window.moment  = moment;
import 'bootstrap/js/dist/popover';
import 'x-editable/dist/bootstrap3-editable/js/bootstrap-editable';
$(function(){

    //modify buttons style
    $.fn.editableform.buttons =
        '<button type="submit" class="btn btn-primary editable-submit btn-sm waves-effect waves-light"><i class="mdi mdi-check"></i></button>' +
        '<button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect"><i class="mdi mdi-close"></i></button>';

    //Inline editables
    $('#inline-username').editable({
        type: 'text',
        pk: 1,
        name: 'username',
        title: 'Enter username',
        mode: 'inline',
        inputclass: 'form-control-sm form-control'
    });

    $('#inline-firstname').editable({
        validate: function(value) {
            if($.trim(value) == '') return 'This field is required';
        },
        mode: 'inline',
        inputclass: 'form-control-sm form-control'
    });

    $('#inline-sex').editable({
        prepend: "not selected",
        mode: 'inline',
        inputclass: 'form-select-sm form-select',
        source: [
            {value: 1, text: 'Male'},
            {value: 2, text: 'Female'}
        ],
        display: function(value, sourceData) {
            var colors = {"": "gray", 1: "green", 2: "blue"},
                elem = $.grep(sourceData, function(o){return o.value == value;});

            if(elem.length) {
                $(this).text(elem[0].text).css("color", colors[value]);
            } else {
                $(this).empty();
            }
        }
    });

    $('#inline-group').editable({
        showbuttons: false,
        mode: 'inline',
        inputclass: 'form-select-sm form-select'
    });

    $('#inline-status').editable({
        mode: 'inline',
        inputclass: 'form-select-sm form-select'
    });

    $('#inline-dob').editable({
        mode: 'inline',
        inputclass: 'form-select-sm form-select'
    });

    $('#inline-event').editable({
        placement: 'bottom',
        showbuttons:"bottom",
        mode: 'inline',
        combodate: {
            firstItem: 'name'
        },
        inputclass: 'form-select-sm form-select'
    });

    $('#inline-comments').editable({
        showbuttons: 'bottom',
        mode: 'inline',
        inputclass: 'form-control-sm form-control'
    });

    $('#inline-fruits').editable({
        pk: 1,
        limit: 3,
        mode: 'inline',
        inputclass: 'form-check-input',
        source: [
            {value: 1, text: 'Banana'},
            {value: 2, text: 'Peach'},
            {value: 3, text: 'Apple'},
            {value: 4, text: 'Watermelon'},
            {value: 5, text: 'Orange'}
        ]
    });

});
