<!DOCTYPE html>
<html lang="en" class="">
    <?php include 'view/admin/admin_template/style_css.php'; ?>
    <body>
        <div class="app app-header-fixed " >
            <?php include 'view/admin/admin_template/header.php'; ?>
            <?php include 'view/admin/admin_template/sidebar.php'; ?>
                <div id="content" class="app-content" role="main">
                        <div class="app-content-body ">
                            <div class="hbox hbox-auto-xs hbox-auto-sm" >
                                <div class="col" >
                                    <div class="bg-light lter b-b wrapper-md">
                                        <h1 class="m-n font-thin h3">View New Member</h1>
                                    </div>
                                    <div class="wrapper-md" >
                                        <div class="row">
                                    <?php include 'view/admin/admin_template/msg.php';?>
                                        <div class="col-md-12" >
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-md-6">View New Member</div>
                                                        <div class="col-md-6">

                                                           <!--  <a href="<?=admin_url?>/viewnewmember/add" class="btn btn-success btn-xs pull-right" title="Add New Page">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                                            </a> -->
                                                             <!-- <button style="margin-right: 10px;" class="btn btn-danger btn-xs pull-right" id="DeletePromocode"><i class="fa fa-trash-o"></i> Delete</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table id="newmember" class="table table-striped table-bordered mydatatable">
                                                                <thead>
                                                                    <tr>
                                                                    <th>
                                                                            <div class="checkbox m-b-md m-t-none">
                                                                                <label class="i-checks">
                                                                                  <input type="checkbox" name="SelectAll" id="select_all"><i></i>
                                                                                </label>
                                                                            </div>
                                                                        </th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Address</th>
                                                                        <th>City</th>
                                                                        <th>Province</th>
                                                                        <th>Postal Code</th>
                                                                        <th>Phone</th>
                                                                        <th>Cell</th>
                                                                        <th>Program</th>
                                                                        <th>Selected T-Shirt</th>

                                                                       
                                                                    </tr>
                                                                </thead>
                                                               
                                                                    
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php include 'view/admin/admin_template/footer.php'; ?>
            <?php include 'view/admin/admin_template/script_js.php'; ?>
              <script type="text/javascript">
            $(document).ready(function () {
                $('#newmember').DataTable({
                    "columns": [
                     {"data": "first_name",
                        "render": function (data, type, full, meta) {

                                  return "<div class='checkbox m-b-md m-t-none'><label class='i-checks'><input class='checkbox' type='checkbox' name='member_id' member_id='"+ full.member_id +"'><i></i></label></div>";
                                  },
                         "orderable": false,
                         "sortable": false
         
                        },
                        {"data": "first_name"},
                        {"data": "email"},
                        {"data": "address"},
                        {"data": "city"},
                        {"data": "province"},
                        {"data": "postal_code"},
                        {"data": "phone_home"},
                        {"data": "phone_cell"},
                        {"data": "program_description"},
                        {"data": "t_shirt"}
                       
                    ],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: admin_url+'/viewnewmembers/pagination',
                        type: 'POST',
                        data:{'table':'members','table2':'registration'}
                    }
                });

            });
         </script>
    </body>
</html>
