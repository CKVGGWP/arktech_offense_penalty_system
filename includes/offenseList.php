<ul class="nav nav-pills justify-content-center border-bottom">
    <a class="nav-link" href="index.php">
        <div class="nav-link border"> <i class="fa-solid fa-file-signature"></i>&nbsp Offense Form </div>
    </a>
</ul>
<div class="d-flex flex-column justify-content-center">
    <div class="col-md-12 mt-3 px-4">
        <!------------------- DataTables Example ----------------->
        <div class="card shadow mb-4">
            <div class="card-body">

                <!------------------------ Textbox Search ----------------------->
                <!-- <div class="row mb-3 ml-1">
                        <div class="form-group mb-3">
                            <label for="userFirstname">Filter & Search</label>
                            <div class="col-sm">
                                <input type="name" class="form-control" id="filter" onkeyup="filter()" name="filter">
                            </div>
                        </div>
                    </div> -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center text-nowrap" id="userTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Name</th>
                                <th class="text-wrap">Offense Type</th>
                                <th class="text-wrap">1st Offense</th>
                                <th class="text-wrap">2nd Offense</th>
                                <th class="text-wrap">3rd Offense</th>
                                <th class="text-wrap">Date Input</th>
                                <th class="text-wrap">Date Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="text-nowrap">Juan Dela Cruz</td>
                            <td class="text-wrap">Due to illness</td>
                            <td class="text-wrap">1st Offense</td>
                            <td class="text-wrap">2nd Offense</td>
                            <td class="text-wrap">3rd Offense</td>
                            <td class="text-wrap">Date Input</td>
                            <td class="text-wrap">Date Updated</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>