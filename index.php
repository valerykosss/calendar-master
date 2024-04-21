
<?php
//index.php




?>
<!DOCTYPE html>
<html>
 <head>
 <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>


  <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'load.php',
    selectable:true,
    selectHelper:true,

    select: function(start, end, allDay)
    {
         // Заполнение полей модального окна значениями
        clearLeaveModal();
        $('#leaveModal').modal('show');  
        $('#leave_start').val($.fullCalendar.formatDate(start, "Y-MM-DD HH:mm"));
        $('#leave_end').val($.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss"));

    },
    editable:true,

    //растягивание события
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;

     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       $("#msgUpdatedModal").modal();
      }
     })
    },

    //изменение границ события - перетаскивание события
    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      error: function(error){
            alert('Something went wrong: ', error);
        },
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       $("#msgUpdatedModal").modal();
      }
     });
    },

    //обработчик нажатия
    eventClick:function(event)
    {
    var id = event.id;

            $.ajax ({
                //вывод
                url:"fetch.php",
                type:"POST",
                data:{id:id},
                error: function(error){
                    alert('Something went wrong: ', error);
                },
                success:function() {
                    calendar.fullCalendar('refetchEvents');
                    
                    $('#leave_title_edit').val(event.title);

                    $('#leave_start').val($.fullCalendar.formatDate(event.start, "YYYY-MM-DD HH:mm"));
                    $('#leave_end').val($.fullCalendar.formatDate(event.end, "YYYY-MM-DD HH:mm"));

                    $('#leaveAddBtn').attr('disabled', true);
                    $('#leaveAddBtn').hide();
                    $('#leaveUpdateBtn').attr('disabled', false);
                    $('#leaveUpdateBtn').show();
                    $('#leaveDeleteBtn').attr('disable', false);
                    $('#leaveDeleteBtn').show();                    

                    $('#leaveModal').modal('show');

                }
            });

              // update по кнопке
            $('#leaveUpdateBtn').click(function(){

                title=$('#leave_title_edit').val();
                start = moment($('#leave_start').val()).format('YYYY-MM-DD HH:mm');
                end = moment($('#leave_end').val()).format('YYYY-MM-DD HH:mm');


                $.ajax({
                    url:"update.php",
                    type:"POST",
                    data: {title:title, start:start, end:end, id:id },
                    error: function(error){
                            alert('Something went wrong: ', error);
                        },
                    success:function() {
                    calendar.fullCalendar('refetchEvents');
                    $("#msgUpdatedModal").modal();
                    }
                })
            }); 

            // delete по кнопке
            $('#leaveDeleteBtn').click(function(){
                $.ajax({
                    url:'delete.php',
                    type:'POST',
                    data:{id:id},
                    error: function(error){
                        alert('Something went wrong: ', error);
                    },
                    success:function() {
                        calendar.fullCalendar('refetchEvents');
                        $('#msgDeletedModal').modal();  
                    }
                })
            });

            // clear modal on hide
            $('#leaveModal').hide(function(){
                clearLeaveModal();
            });

    },

   });
   // clear the event modal
   function clearLeaveModal() {
        $('#leaveModal').find('input').val("");
    
        $("#leave_title").text("Add a New Schedule");

        // format modal buttons
        $('#leaveAddBtn').attr('disabled', false);
        $('#leaveAddBtn').show();
        $('#leaveUpdateBtn').attr('disabled', true);
        $('#leaveUpdateBtn').hide();
        $('#leaveDeleteBtn').attr('disable', true);
        $('#leaveDeleteBtn').hide();
    };
    // add button function
    $('#leaveAddBtn').click(function(){
        title=$('#leave_title_edit').val();
        start = $('#leave_start').val();
        end = $('#leave_end').val();
   
       $.ajax({
           url:'insert.php',
           type:'POST',
           data:{
            title:title,
            start:start,
            end:end
           },
           error: function(error){
               alert('Something went wrong: ', error);
           },
           success:function(data){
               calendar.fullCalendar('refetchEvents');
               $("#msgSuccessModal").modal('show');
               clearLeaveModal();
           }
       });
       
   });
  });
  </script>
  
 </head>
 <body>
  <div class="container">
   <div id="calendar"></div>
  </div>

   <!-- Start Event Modal -->
 <div id="leaveModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="leave_title" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                </div>  
                <div class="modal-body">
                    <form>  
                        <div class="form-group">
                            <label for="start" class="col-form-label">Title: </label>
                            <input type="text" class="form-control" id="leave_title_edit">
                        </div>

                        <!-- <div class="form-group">
                            <label for="start" class="col-form-label">Description: </label>
                            <input type="text" class="form-control" id="leave_description">
                        </div>-->

                        <div class="form-group">
                            <label for="start" class="col-form-label">Start: </label>
                            <input type="text" class="form-control" id="leave_start">
                        </div>

                        <div class="form-group">
                            <label for="start" class="col-form-label">End: </label>
                            <input type="text" class="form-control" id="leave_end">
                        </div>
                    </form>
                </div>  
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="leaveAddBtn">Add</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal" id="leaveUpdateBtn">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="leaveDeleteBtn">Delete</button>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Event Modal -->

    <!-- Start Success Message Modal -->
    <div id="msgSuccessModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Success!</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                </div>
                <div class="modal-body">
                    <p>The leave event has been successfully added to the calendar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Success Message Modal -->

    <!-- Start Updated Message Modal -->
    <div id="msgUpdatedModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Updated!</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                </div>
                <div class="modal-body">
                    <p>The leave event has been successfully updated on the calendar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Updated Message Modal -->

    <!-- Start Deleted Message Modal -->
    <div id="msgDeletedModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Deleted!</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                </div>
                <div class="modal-body">
                    <p>The leave event has been successfully deleted from the calendar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Deleted Message Modal -->
 </body>
</html>
