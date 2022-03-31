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
                    <div class="form-group row firstOffense">
                        <div class="col-4">
                            <p class="fw-bold">First Offense</p>
                        </div>
                        <div class="col row mx-0">
                            <div class="form-check col-3">
                                <input type="radio" value="1" class="form-check-input" id="firstOffenseYes" name="firstOffense" required>
                                <label class="form-check-label" for="radioYes">Yes</label>
                            </div>
                            <div class="form-check col">
                                <input type="radio" value="0" class="form-check-input" id="firstOffenseNo" name="firstOffense">
                                <label class="form-check-label" for="radioNo">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row secondOffense">
                        <div class="col-4">
                            <p class="fw-bold">Second Offense</p>
                        </div>
                        <div class="col row mx-0">
                            <div class="form-check col-3">
                                <input type="radio" value="1" class="form-check-input" id="secondOffenseYes" name="secondOffense" required>
                                <label class="form-check-label" for="radioYes">Yes</label>
                            </div>
                            <div class="form-check col">
                                <input type="radio" value="0" class="form-check-input" id="secondOffenseNo" name="secondOffense">
                                <label class="form-check-label" for="radioNo">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row thirdOffense">
                        <div class="col-4">
                            <p class="fw-bold">Third Offense</p>
                        </div>
                        <div class="col row mx-0">
                            <div class="form-check col-3">
                                <input type="radio" value="1" class="form-check-input" id="thirdOffenseYes" name="thirdOffense" required>
                                <label class="form-check-label" for="radioYes">Yes</label>
                            </div>
                            <div class="form-check col">
                                <input type="radio" value="0" class="form-check-input" id="thirdOffenseNo" name="thirdOffense">
                                <label class="form-check-label" for="radioNo">No</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block text-light" id="submit" onclick="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8 mt-3">
        <div class="card shadow mb-4">
            <div class="card-body">
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

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>