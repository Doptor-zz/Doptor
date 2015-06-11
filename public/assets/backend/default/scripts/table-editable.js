var serialized = '';
var TableEditable = function () {
    if (window.location.href.indexOf('menu-manager') != -1) {
        var current_url = 'menu-manager';
    } else if (window.location.href.indexOf('form-categories') != -1) {
        var current_url = 'form-categories';
    } else if (window.location.href.indexOf('menu-categories') != -1) {
        var current_url = 'menu-categories';
    }
    return {

        //main function to initiate the module
        init: function () {
            function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }

                oTable.fnDraw();
            }

            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML = '<input type="text" class="m-wrap small" value="' + aData[0] + '" disabled>';
                jqTds[1].innerHTML = '<input type="text" class="m-wrap small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" class="m-wrap small" value="' + aData[2] + '">';
                status = (current_url == 'form-categories' || current_url == 'menu-categories') ? 'disabled' : '';
                jqTds[3].innerHTML = '<input type="text" class="m-wrap small span" value="' + aData[3] + '" ' + status + ' >';
                jqTds[4].innerHTML = '<a class="btn btn-mini edit" href=""><i class="icon-save"></i> Save</a>';
                jqTds[5].innerHTML = '<a class="btn btn-mini cancel" href=""><i class="icon-remove"></i> Cancel</a>';
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);

                element_row_id = nRow.getElementsByClassName('element-row-id')[0].textContent;

                oTable.fnUpdate('<a class="edit btn btn-mini" href="javascript:;"><i class="icon-edit"></i> Quick Edit</a><br> <a href="' + current_url + '/' + element_row_id + '/edit" class="btn btn-mini"><i class="icon-edit"></i> Full Edit</a>', nRow, 4, false);
                oTable.fnUpdate('<a class="btn btn-danger btn-mini delete" href=""><i class="icon-trash"></i> Delete</a>', nRow, 5, false);
                oTable.fnDraw();
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate('<a class="btn btn-mini edit" href="">Edit</a>', nRow, 4, false);
                oTable.fnDraw();
            }

            var oTable = $('#sample_editable_1').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 15,
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': true,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#sample_editable_1_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
            jQuery('#sample_editable_1_wrapper .dataTables_length select').addClass("m-wrap xsmall"); // modify table per page dropdown

            var nEditing = null;

            $('#sample_editable_1_new').click(function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '',
                        '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
            });

            $('#sample_editable_1 a.delete').live('click', function (e) {
                e.preventDefault();

                if (confirm("Are you sure to delete this row ?") == false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];

                element_row_id = nRow.getElementsByClassName('element-row-id')[0].textContent;

                // Send the data to server to validate and update
                $.ajax( {
                    type: 'DELETE',
                    url: current_url + '/' + element_row_id,
                    success: function(response) {
                        oTable.fnDeleteRow(nRow);
                        $('#errors-div').html('<div class="alert alert-success"> <button data-dismiss="alert" class="close">×</button> <strong>Success!</strong> ' + response + '</div>') },
                    error: function(response) {
                        window.response = response;
                        $('#errors-div').html('<div class="alert alert-error"> <button data-dismiss="alert" class="close">×</button> <strong>Error!</strong> ' + JSON.parse(response.responseText) + '</div>');
                    }
                });
            });

            $('#sample_editable_1 a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            $('#sample_editable_1 a.edit').live('click', function (e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && this.innerHTML.contains("Save")) {
                    /* Editing this row and want to save it */
                    if (current_url == 'menu-manager') {
                        $('#sample_editable_1 input').each(function(index, value) {
                            serialized += (index == 0) ? '&parent=' + $(this).val() : '';
                            serialized += (index == 1) ? '&title=' + $(this).val() : '';
                            serialized += (index == 2) ? '&link=' + $(this).val() : '';
                            serialized += (index == 3) ? '&order=' + $(this).val() : '';
                        });
                        element_row_id = nRow.getElementsByClassName('element-row-id')[0].textContent;
                    } else if (current_url == 'form-categories' || current_url == 'menu-categories') {
                        $('#sample_editable_1 input').each(function(index, value) {
                            serialized += (index == 1) ? '&name=' + $(this).val() : '';
                            serialized += (index == 2) ? '&description=' + $(this).val() : '';
                        });
                        element_row_id = nRow.getElementsByClassName('element-row-id')[0].getElementsByTagName('input')[0].value;
                    }

                    // Send the data to server to validate and update
                    $.ajax( {
                        type: 'PUT',
                        url: current_url + '/' + element_row_id,
                        data: serialized,
                        success: function(response) {
                            saveRow(oTable, nEditing);
                            nEditing = null;
                            $('#errors-div').html('<div class="alert alert-success"> <button data-dismiss="alert" class="close">×</button> <strong>Success!</strong> ' + response + '</div>') },
                        error: function(response) {
                            window.response = response;
                            $('#errors-div').html('<div class="alert alert-error"> <button data-dismiss="alert" class="close">×</button> <strong>Error!</strong> ' + JSON.parse(response.responseText) + '</div>');
                        }
                    });

                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });
        }

    };

}();
