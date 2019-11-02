// Call the dataTables jQuery plugin
$(document).ready(function() {
    var table = $('#dataTable').DataTable( {
        "rowReorder": true,
        "paging": false
    } );
    table.on( 'row-reorder', function ( e, diff, edit ) {
        console.log('Reorder started on row: '+edit.triggerRow.data()[0]);
        
        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            //var rowData = table.row( diff[i].node ).data();
              if(diff[i].oldData==edit.triggerRow.data()[0]){
                  console.log('Row move from '+diff[i].oldData+' to '+diff[i].newData);
                  increase_order(diff[i].oldData, diff[i].newData);
              }
            //result += rowData[1]+' updated to be in position '+ diff[i].newData+' (was '+diff[i].oldData+')<br>';
        }
        
    } );

    //Delete buttons
    $('.dt-delete').each(function () {
        $(this).on('click', function(evt){
            $this = $(this);
            var dtRow = $this.parents('tr');
            var order = dtRow[0].cells[0].innerText;
            if(confirm("Are you sure to delete this signage?")){
                var table = $('#example').DataTable();
                table.row(dtRow[0].rowIndex-1).remove().draw( false );
                
                $.ajax({
                    type  : 'POST',
                    url   : '../../signages/remove_order/'+$('input[name=id]').val(),
                    data: ({ "order" : order }),
                    async : true,
                    dataType : 'text',
                    success : function(data){
                        if(data){
                         location.reload();
                        } else {
                          alert("Failed to sort the menu, please try again later...");
                          location.reload();
                        }
                    }
            
                });
            }
        });
    });

    //Edit buttons
    $('.dt_edit').each(function () {
        $(this).on('click', function(evt){
            $this = $(this);
            var dtRow = $this.parents('tr');
            var order = dtRow[0].cells[0].innerText;
            var start_time = dtRow[0].cells[2].innerText;
            var end_time = dtRow[0].cells[3].innerText;
            $("#update_start_time").val(start_time);
            $("#update_end_time").val(end_time);
            $("#update_time_order").val(order);
            $('#editSignage').modal('show');
        });
    });

  });
  
  
  function increase_order(from, to){
    $.ajax({
        type  : 'POST',
        url   : '../../signages/change_order/'+$('input[name=id]').val(),
        data: ({ "from" : from, "to": to }),
        async : true,
        dataType : 'text',
        success : function(data){
            if(data){
              
            } else {
              alert("Failed to sort the menu, please try again later...");
              location.reload();
            }
        }
  
    });
    
  }
  
  
  function popSignage(url){
    var ext = url.substr(url.lastIndexOf('.') + 1);
    $("#popup-holder").empty();
    if(ext=="mp4"){
        $("#popup-holder").html('<video src="../../uploads/signages/'+url+'" class="img-fluid" controls></video>');
    } else {
      $("#popup-holder").html('<img src="../../uploads/signages/'+url+'" class="img-fluid">');
    }
    
    $('#myImage').modal('show');
  }