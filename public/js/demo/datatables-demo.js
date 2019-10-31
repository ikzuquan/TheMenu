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
  $("#ImagePlaceholder").attr("src", "../../uploads/"+$url);
  $('#myImage').modal('show');
}