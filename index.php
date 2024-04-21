
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

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/ru.js"></script> -->


  <script>
   
  $(document).ready(function() {

    // Загрузка списка мастеров при загрузке страницы
    loadMasters();

    function loadMasters() {
        $.ajax({
            url: 'getMasters.php',  // PHP-скрипт для загрузки мастеров
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // $('#master_select').empty();  // Очищаем выпадающий список

                $.each(response, function(index, master) {
                    $('#master_select').append($('<option>', {
                        value: master.id,
                        text: master.name
                    }));
                });
            },
            error: function(error) {
                console.error('Ошибка при загрузке мастеров:', error);
            }
        });
    }

   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'agendaWeek, month'
    },
    events: 'load.php',
    selectable:true,
    defaultView: 'agendaWeek',
    selectHelper:true,
    locale: 'ru', // Устанавливаем русский язык
    timeFormat: 'HH:mm',

    select: function(start, end, allDay)
    {
         // Заполнение полей модального окна значениями
        clearLeaveModal();
        $('#leaveModal').modal('show');  
        $('#leave_start').val($.fullCalendar.formatDate(start, "YYYY-MM-DD HH:mm"));
        $('#leave_end').val($.fullCalendar.formatDate(end, "YYYY-MM-DD HH:mm"));

    },
    editable:true,

    //растягивание события вниз
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD HH:mm");
     var end = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD HH:mm");
     var id_master = event.id_master;
     var id = event.id;

     $.ajax({
      url:"update.php",
      type:"POST",
      data:{ id_master:id_master, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       $("#msgUpdatedModal").modal();
      }
     })
    },

    //изменение границ события - перетаскивание события
    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD HH:mm");
     var end = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD HH:mm");
     var id_master = event.id_master;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{id_master:id_master, start:start, end:end, id:id},
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
        // $('#eventIdInput').val(event.id);
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
                    
                    $('#master_select').val(event.id_master);

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
                // var id = $('#eventIdInput').val(); // Получение id события из скрытого поля ввода

                // $('#master_select').val(event.id_master);

                id_master=$('#master_select').val();
                alert("АЙДИ МАСТЕРА ". id_master);

                start = moment($('#leave_start').val()).format('YYYY-MM-DD HH:mm');
                end = moment($('#leave_end').val()).format('YYYY-MM-DD HH:mm');
                
                // alert("АЙДИ ". id);
                
                // var id = $('#eventIdInput').val();

                $.ajax({
                    url:"update.php",
                    type:"POST",
                    data: {id_master:id_master, start:start, end:end, id:id },
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
    
        $("#leave_title").text("Расписание");

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
        id_master=$('#master_select').val();
        start = $('#leave_start').val();
        end = $('#leave_end').val();

   
       $.ajax({
           url:'insert.php',
           type:'POST',
           data:{
            id_master: id_master,
            start: start,
            end: end
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
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">Закрыть</span></button>
                </div>  
                <div class="modal-body">
                    <form>  
                        <!-- <div class="form-group">
                            <label for="start" class="col-form-label">Title: </label>
                            <input type="text" class="form-control" id="leave_title_edit">
                        </div> -->

                        <!-- <div class="form-group">
                            <label for="start" class="col-form-label">Description: </label>
                            <input type="text" class="form-control" id="leave_description">
                        </div>-->

                        <div class="form-group">
                            <label for="master_select" class="col-form-label">Мастер: </label>
                            <select class="form-control" id="master_select">
                            </select>
                        </div>
                        <input type="hidden" id="eventIdInput">

                        <div class="form-group">
                            <label for="start" class="col-form-label">Начало времени работы: </label>
                            <input type="text" class="form-control" id="leave_start">
                        </div>

                        <div class="form-group">
                            <label for="start" class="col-form-label">Конец времени работы: </label>
                            <input type="text" class="form-control" id="leave_end">
                        </div>
                    </form>
                </div>  
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="leaveAddBtn">Добавить</button>
                    <!-- <button type="button" class="btn btn-warning" data-dismiss="modal" id="leaveUpdateBtn">Update</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="leaveDeleteBtn">Удалить</button>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Отмена</button>
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
                    <h4 class="modal-title">Успешно!</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">Закрыть</span></button>
                </div>
                <div class="modal-body">
                    <p>Расписание было успешно добавлено!</p>
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
                    <h4 class="modal-title">Расписание обновлено!</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                </div>
                <div class="modal-body">
                    <p>Расписание было успешно обновлено!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Закрыть</button>
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
                    <h4 class="modal-title">Расписание удалено!</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">Закрыть</span></button>
                </div>
                <div class="modal-body">
                    <p>Расписание было успешно удалено!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Deleted Message Modal -->
 </body>
</html>
