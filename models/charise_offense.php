<?php

class Offense extends Database
{
    public function categoryLevel($level, $categoryNum = '')
    {
        $data = [];
        //Query the database for the category level
        $sql = "SELECT 
                o.offenseId AS id, 
                o.offenseType AS offenseType 
                FROM offense o
                JOIN offense_level l ON o.offenseId = l.childId
                WHERE l.offenseLevel = '$level'";

        if (!empty($categoryNum)) {
            $sql .= " AND l.parentId = '$categoryNum'";
        }

        $query = $this->connect()->query($sql);

        while ($row = $query->fetch_assoc()) {
            $data[] = $row;
        }

        //Determining the Level of the Offense
        if ($level == 2) {
            $data = $this->categoryOption($data);
        } else if ($level == 3) {
            $data = $this->categoryOption($data);
        }

        return $data;
    }

    //Category Options
    private function categoryOption($data)
    {
        $option = '';

        $option .= '<option selected disabled>Choose a sub-offense</option>';

        if (!empty($data)) {
            foreach ($data as $row) {
                $option .= '<option value="' . $row['id'] . '">' . $row['offenseType'] . '</option>';
            }
        } else {
            $option .= '<option selected disabled>No Data to Display</option>';
        }

        return json_encode($option);
    }

    public function getTable($id = '', $table = '')
    {
        $data = [];
        $totalData = 1;
        $penaltyArray = [];

        $sql = "SELECT 
                listId, 
                idNumber, 
                offenseId, 
                offense1, 
                offense2, 
                offense3, 
                dateInput, 
                dateUpdate 
                FROM offense_list";

        if ($id != '') {
            $sql .= " WHERE idNumber = '$id'";
        }

        $query = $this->connect()->query($sql);

        if ($query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                extract($row);

                $employee = $this->selectEmployee($idNumber);

                foreach ($employee as $key => $empRow) {
                    $employeeName = $empRow['firstName'] . " " . $empRow['surName'];
                }

                $offenseId = str_split($offenseId);
                $offenseType = $this->selectOffenseType($offenseId);
                $offenses1 = str_split($offense1);
                $offenses2 = ($offense2 != '') ? str_split($offense2) : '';
                $offenses3 = ($offense3 != '') ? str_split($offense3) : '';

                $penaltyArray = array(
                    'offense1' => $this->selectPenaltyType($offenses1),
                    'offense2' => $this->selectPenaltyType($offenses2),
                    'offense3' => $this->selectPenaltyType($offenses3),
                );

                if ($table != '') {
                    $data[] = [
                        $totalData,
                        $employeeName,
                        $offenseType,
                        ($penaltyArray['offense1'] == '') ? "" : $penaltyArray['offense1'],
                        ($penaltyArray['offense2'] == '') ? "" : $penaltyArray['offense2'],
                        ($penaltyArray['offense3'] == '') ? "" : $penaltyArray['offense3'],
                        ($dateInput == "0000-00-00 00:00:00") ? "" : date("F j, Y - H:i:s", strtotime($dateInput)),
                        ($dateUpdate == "0000-00-00 00:00:00") ? "" : date("F j, Y - H:i:s", strtotime($dateUpdate))

                    ];
                } else {
                    $data[] = [
                        $totalData,
                        $offenseType,
                        ($penaltyArray['offense1'] == '') ? "" : $penaltyArray['offense1'],
                        ($penaltyArray['offense2'] == '') ? "" : $penaltyArray['offense2'],
                        ($penaltyArray['offense3'] == '') ? "" : $penaltyArray['offense3'],
                        ($dateInput == "0000-00-00 00:00:00") ? "" : date("F j, Y - H:i:s", strtotime($dateInput)),
                        ($dateUpdate == "0000-00-00 00:00:00") ? "" : date("F j, Y - H:i:s", strtotime($dateUpdate))

                    ];
                }

                $totalData++;
            }
        }

        $json_data = array(
            "draw"            => 1,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalData), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array

        );

        return json_encode($json_data);  // send data as json format
    }

    private function selectPenaltyType($id)
    {
        $penaltyCode = [];

        $sql = "SELECT penaltyCode FROM offense_penalty";

        if (is_array($id)) {
            $sql .= " WHERE penaltyId IN (" . implode(',', $id) . ")";
        } else {
            $sql .= " WHERE penaltyId = '$id'";
        }

        $query = $this->connect()->query($sql);

        while ($row = $query->fetch_assoc()) {
            $penaltyCode[] = $row['penaltyCode'];
        }

        if (is_array($penaltyCode)) {
            return implode('-', $penaltyCode);
        } else {
            return $penaltyCode;
        }
    }

    private function selectOffenseType($id)
    {
        $offenseType = [];

        $sql = "SELECT offenseType FROM offense";

        if (is_array($id)) {
            $sql .= " WHERE offenseId IN (" . implode(',', $id) . ")";
        } else {
            $sql .= " WHERE offenseId = '$id'";
        }

        $query = $this->connect()->query($sql);

        while ($row = $query->fetch_assoc()) {
            $offenseType[] = $row['offenseType'];
        }

        $offenseType = array_map(function ($offenseType) {
            return substr($offenseType, 0, -1);
        }, $offenseType);

        return implode('<br><b>', $offenseType);
    }

    public function selectEmployee($id = '')
    {
        $sql = "SELECT 
                DISTINCT
                idNumber, 
                firstName, 
                surName
                FROM hr_employee";

        if ($id != '') {
            $sql .= " WHERE idNumber = '$id'";
        }

        $sql .= " GROUP BY idNumber";

        $query = $this->connect()->query($sql);

        $data = [];

        while ($row = $query->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function selectHR($id)
    {
        $sql = "SELECT 
                e.idNumber 
                FROM hr_employee e
                LEFT JOIN hr_positions p ON e.position = p.positionId
                WHERE p.positionName = 'HR Staff' 
                AND e.status = 1
                AND e.idNumber = '$id'";
        $query = $this->connect()->query($sql);

        if ($query->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function selectIT($id)
    {
        $sql = "SELECT 
                idNumber 
                FROM hr_employee 
                WHERE departmentId = '4' 
                AND sectionId = '0'
                AND status = '1'
                AND idNumber = '$id'";
        $query = $this->connect()->query($sql);

        if ($query->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addOffense($data)
    {
        $off = $data['category1'] . $data['category2'];

        $offense = $this->checkOffense($data['employee'], $off);

        if ($offense != false) {
            echo $this->updateOffense($data);
        } else {
            echo $this->insertOffense($data, $off);
        }
    }

    private function insertOffense($data, $off)
    {
        if ($off == '46') {
            $penalty = '123';
        } else {
            $penalty = '1';
        }

        if ($off <= 6) {
            return 4;
            exit();
        }

        $sql = "INSERT INTO offense_list(idNumber, offenseId, offense1, offense2, offense3, dateInput)
 				VALUES ('" . $data['employee'] . "', '$off', '$penalty', '', '', '" . $data['date'] . "')";
        $query = $this->connect()->query($sql);

        if ($query) {
            return 1;
        } else {
            return 2;
        }
    }

    private function updateOffense($data)
    {
        $off = $data['category1'] . $data['category2'];
        $offense = $this->checkOffense($data['employee'], $off);
        $offenseId = $data['category2'];

        foreach ($offense as $key => $row) {
            if ($row['offense2'] != 0) {
                $offenseNum = '3';
            } else {
                $offenseNum = '2';
            }
        }

        $penalty = $this->selectPenalty($offenseId, $offenseNum);

        $sql = "UPDATE 
                offense_list o
                LEFT JOIN hr_employee e ON e.idNumber = o.idNumber 
                SET o.offense" . $offenseNum . " = '$penalty', 
                o.dateUpdate = now()";
        if ($offenseId == '6') {
            $sql .= " ,e.status = 0";
        }

        $sql .= " WHERE o.idNumber = '" . $data['employee'] . "' 
                AND o.offenseId ='" . $off . "'";

        $query = $this->connect()->query($sql);

        if ($query) {
            return 3;
        } else {
            return 2;
        }
    }

    private function checkOffense($id, $offenseId)
    {
        $data = [];
        $sql = "SELECT 
                offense1,
                offense2,
                offense3
                FROM offense_list
                WHERE idNumber = '$id'";

        if ($offenseId != "") {
            $sql .= " AND offenseId = '$offenseId'";
        }

        $query = $this->connect()->query($sql);

        if ($query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    private function selectPenalty($offenseId, $offenseNum)
    {
        $penalty = array(
            '1st' => '1',
            '2nd' => '2',
            '3rd' => '3',
            '4th' => '4',
            '5th' => '5',
            '6th' => '6',
        );

        $id = '';

        if ($offenseNum == 2) {
            if ($offenseId == 2 or $offenseId == 5) {
                $id .= $penalty['2nd'];
            } else if ($offenseId == 3) {
                $id .= $penalty['3rd'];
            } else if ($offenseId == 6) {
                $id .= $penalty['6th'];
            }
        } else {
            if ($offenseId == 2 or $offenseId == 3 or $offenseId == 5) {
                $id .= $penalty['6th'];
            }
        }

        return $id;
    }

    public function selectTerminatedOffense($id)
    {
        $button = '';
        $sql = "SELECT * FROM offense_list WHERE (offense2 = 6 OR offense3 = 6) AND idNumber = '$id'";
        $query = $this->connect()->query($sql);

        if ($query->num_rows > 0) {
            $button .= '<button disabled class="btn btn-danger btn-block text-light">Employee Terminated</button>';
        } else {
            $button .= '<button type="submit" name="submit" class="btn btn-primary btn-block text-light" id="submit">Submit</button>';
        }

        return json_encode($button);
    }
}
