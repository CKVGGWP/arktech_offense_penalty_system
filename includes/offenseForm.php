<?php include('controllers/charise_offenseController.php'); ?>

<ul class="nav nav-pills justify-content-center border-bottom">
    <a class="nav-link" href="charise_offenseList.php">
        <div class="nav-link border"> <i class="fa-solid fa-rectangle-list"></i>&nbsp Manage Offense List </div>
    </a>
</ul>
<div class="row">
    <div class="col-md-4 mt-3">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="POST" id="offenseForm">
                    <!-- EDITED BY CK -->
                    <div class="form-group">
                        <div class="col-lg-12 mb-2">
                            <label class="fw-bold" for="category1">Employee: </label>
                            <select class="form-control selectpicker mb-2" name="employee" id="employee" data-live-search="true" required>
                                <option value="" selected disabled>Select an employee</option>
                                <?php
                                foreach ($employee as $key => $row) :
                                    echo '<option value="' . $row['idNumber'] . '">' . $row['firstName'] . ' ' . $row['surName'] . '</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group" id="category1Group">
                            <label class="fw-bold" for="category1">Offense Type: </label>
                            <select name="category1" class="form-select mb-2" id="category1" required>
                                <option value="" selected disabled>Choose an offense</option>
                                <?php
                                if (!empty($data)) :
                                    foreach ($data as $key => $row) :
                                        echo "<option value='" . $row['id'] . "'>" . $row['offenseType'] . "</option>";
                                    endforeach;
                                else :
                                    echo "<option value=''>No Data to Display</option>";
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="form-group" id="category2Group">
                            <label class="fw-bold" for="category2">Offense: </label>
                            <select class="form-select mb-2" id="category2">
                                <option value="" selected disabled>Choose a sub-offense</option>

                            </select>
                        </div>
                    </div>
                    <div id="buttonSubmit">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8 mt-3">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="userTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">#</th>
                                <th class="text-wrap text-center">Offense Type</th>
                                <th class="text-wrap text-center">1st Offense</th>
                                <th class="text-wrap text-center">2nd Offense</th>
                                <th class="text-wrap text-center">3rd Offense</th>
                                <th class="text-wrap text-center">Date Input</th>
                                <th class="text-wrap text-center">Date Updated</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>