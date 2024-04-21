$(document).ready(function() {
    var calendar = $('#leave_calendar').fullCalendar({
        editable:true,
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        events: 'assets/js/load.php',
        selectable:true,
        selectHelper:true,
        
        select: function(start,end, allDay) {
            var title=$('#leave_title').val();
            var description=$('#leave_description').val();

            $('#leave_start').data("DateTimePicker").date(moment(start).format('YYYY-MM-DD'));
            $('#leave_end').data("DateTimePicker").date(moment(end).format('YYYY-MM-DD'));

            clearLeaveModal();
            $('#leaveModal').modal('show');           
        },
        editable:true,

        eventResize:function(event) {
            var start = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD 08:00:00");
            var end = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD 17:00:00");
            // var draft_due_date = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD");
            var title = event.title;
            var description = event.description;

            var id = event.id;

            $.ajax({
                url:"assets/js/update.php",
                type:"POST",
                data:{
                    title:title,
                    description:description,
                    start:start,
                    end:end, 
                    id:id
                },
                success:function(){
                    calendar.fullCalendar('refetchEvents');
                    $("#msgUpdatedModal").modal();
                }
            });
        },
    
        eventDrop:function(event) {
            var start = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD 08:00:00");
            var end = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD 17:00:00");
            var title = event.title;
            var description = event.description;
            var id = event.id;

            $.ajax({
                url:"assets/js/update.php",
                type:"POST",
                data:{
                    title:title,
                    description:description,
                    start:start,
                    end:end,
                    id:id
                },
                error: function(error){
                    alert('Something went wrong: ', error);
                },
                success:function() {
                    calendar.fullCalendar('refetchEvents');
                    $("#msgUpdatedModal").modal();
                }
            });
        },
    
        eventClick:function(event) {
            var id = event.id;
            $.ajax ({
                url:"assets/js/fetch.php",
                type:"POST",
                data:{id:id},
                error: function(error){
                    alert('Something went wrong: ', error);
                },
                success:function() {
                    calendar.fullCalendar('refetchEvents');
                    
                    $('#leave_title').html(event.title);
                    $('#leave_title_edit').val(event.title);
                    $('#leave_description').val(event.description);
                    $('#leave_start').val($.fullCalendar.formatDate(event.start, "YYYY-MM-DD"));
                    $('#leave_end').val($.fullCalendar.formatDate(event.end, "YYYY-MM-DD"));

                    $('#leaveAddBtn').attr('disabled', true);
                    $('#leaveAddBtn').hide();
                    $('#leaveUpdateBtn').attr('disabled', false);
                    $('#leaveUpdateBtn').show();
                    $('#leaveDeleteBtn').attr('disable', false);
                    $('#leaveDeleteBtn').show();                    

                    $('#leaveModal').modal('show');

                }
            });

              // update button function
            $('#leaveUpdateBtn').click(function(){
                title=$('#leave_title_edit').val();
                description=$('#leave_description').val();
                s = $('#leave_start').val();
                start = s.concat(' 08:00:00');
                
                e = $('#leave_end').val();
                end=e.concat(' 17:00:00');
            
                $.ajax({
                    url:'assets/js/update.php',
                    type:'POST',
                    data:{
                        title:title,
                        description:description,
                        start:start,
                        end:end,
                        id:id
                    },
                    error: function(error){
                        alert('Something went wrong: ', error);
                    },
                    success:function() {
                        calendar.fullCalendar('refetchEvents');
                        $("#msgUpdatedModal").modal();
                    }
                });

            }); 

            // delete button function
            $('#leaveDeleteBtn').click(function(){
                $.ajax({
                    url:'assets/js/delete.php',
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
    // set datetimepicker inputs
    $("#leave_start, #leave_end").datetimepicker({
            sideBySide: false,
            format: 'YYYY-MM-DD'
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
    // add button fucntion
    $('#leaveAddBtn').click(function(){
        title=$('#leave_title_edit').val();
        description=$('#leave_description').val();
        s = $('#leave_start').val();
        start = s.concat(' 08:00:00');
        
        e = $('#leave_end').val();
        end=e.concat(' 17:00:00');
   
       $.ajax({
           url:'assets/js/insert.php',
           type:'POST',
           data:{
            title:title,
            description:description,
            start:start,
            end:end,
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