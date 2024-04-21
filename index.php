<?php
//index.php




?>
<!DOCTYPE html>
<html>
 <head>
  <title>Jquery Fullcalandar Integration with PHP and Mysql</title>

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


  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script> -->

  
  
 </head>
 <body>
  <div class="container">
   <div id="leave_calendar"></div>
   <div id='datepicker'></div>
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

                        <div class="form-group">
                            <label for="start" class="col-form-label">Description: </label>
                            <input type="text" class="form-control" id="leave_description">
                        </div>

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

    <script src="assets/js/calendar.js"></script>
 </body>
</html>

