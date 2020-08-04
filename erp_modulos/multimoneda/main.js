$(document).ready(function () {
     $('#tableMultimoneda').bootstrapTable({
          
     })
     $.datepicker.setDefaults({
          dateFormat: 'yy-mm-dd'
     });
     $(function () {
          $("#from_date").datepicker();
     });
     $('#filter').click(function () {
          var from_date = $('#from_date').val();
          if (from_date != '') {
               $.ajax({
                    url: "filter.php",
                    method: "POST",
                    data: {
                         from_date: from_date
                    },
                    success: function (data) {
                         $('#tableMultimoneda').html(data);
                    }
               });
          } else {
               alert("Selecciona una fecha");
          }
     });
});

//maxdate