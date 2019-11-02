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
    selected = "";
    $('#dataTable').on("click", "button", function(){
      //console.log($(this).parent());
      selected = $(this).parents('tr');
      bootbox.confirm({
          message: "Do you want to delete this menu?",
          buttons: {
              
              cancel: {
                  label: 'No',
                  className: 'btn-light'
              },
              confirm: {
                label: 'Yes',
                className: 'btn-danger'
            }
          },
          callback: function (result) {
              if(result){
                console.log('This was logged in the callback: ' + result);
                table.row(selected).remove().draw(false);
                console.log(selected.attr('id'));
                $.ajax({
                    type  : 'POST',
                    url   : '../../menus/remove_order/'+$('input[name=id]').val(),
                    data: ({ "order" : selected.attr('id') }),
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
              
          }
      });
      
    });
  });
  
  
  
  function increase_order(from, to){
    $.ajax({
        type  : 'POST',
        url   : '../../menus/change_order/'+$('input[name=id]').val(),
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
  
  function popImage($url){
    $("#ImagePlaceholder").attr("src", "../../uploads/menus/"+$url);
    $('#myImage').modal('show');
  }