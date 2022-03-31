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

    public function getTable($id = '')
    {
        $data = [];
        $totalData = 0;

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

                if ($offenseId > 6) {
                    $offenseId = str_split($offenseId);
                    $offenseId = $offenseId[0] . '.' . $offenseId[1] . '.' . $offenseId[2];
                } else {
                    $offenseId = $offenseId;
                }

                $data[] = [
                    $idNumber,
                    $offenseId,
                    ($offense1 == 0) ? "No" : "Yes",
                    ($offense2 == 0) ? "No" : "Yes",
                    ($offense3 == 0) ? "No" : "Yes",
                    ($dateInput == "0000-00-00 00:00:00") ? "" : date("F j, Y", strtotime($dateInput)),
                    ($dateUpdate == "0000-00-00 00:00:00") ? "" : date("F j, Y", strtotime($dateUpdate))
                ];
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

    public function selectEmployee()
    {
        $sql = "SELECT
                e.idNumber, 
                e.firstName, 
                e.surName
                FROM hr_employee e
                JOIN hr_dtr d ON e.idNumber = d.employeeId
                GROUP BY e.idNumber";
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
        $offense = $this->checkOffense($data['idNumber']);
        $offenses = '';

        if ($offense != FALSE) {
            while ($row = $offense->fetch_assoc()) {
                extract($row);

                $offenses .= $this->selectPenalty($data['category2'], $offense1, $offense2, $offense3);
            }
        } else {
            $offenses .= $this->selectPenalty($data['category2']);
        }

        $sql = "INSERT INTO offense_list(idNumber, offenseId, offense1, offense2, offense3, dateInput)
 				VALUES ('" . $data['employee'] . "', '" . $offenses . "', '" . $data['firstOffense'] . "', '" . $data['secondOffense'] . "', '" . $data['thirdOffense'] . "', '" . $data['date'] . "')";
        $query = $this->connect()->query($sql);

        if ($query) {
            return 1;
        } else {
            return 2;
        }
    }

    private function checkOffense($id)
    {
        $sql = "SELECT 
                offense1,
                offense2,
                offense3
                FROM offense_list
                WHERE idNumber = '$id'";
        $query = $this->connect()->query($sql);

        if ($query->num_rows > 0) {
            return $query;
        } else {
            return false;
        }
    }

    private function selectPenalty($offenseId, $offense1 = '', $offense2 = '', $offense3 = '')
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

        if ($offense1 == 0 && $offense2 == 0 && $offense3 == 0) {
            if ($offenseId == 2 or $offenseId == 3 or $offenseId == 5) {
                $id .= $penalty['1st'];
            } else if ($offenseId == 6) {
                $id .= $penalty['1st'] . $penalty['2nd'] . $penalty['3rd'];
            }
        } else if ($offense1 == 1 && $offense2 == 0 && $offense3 == 0) {
            if ($offenseId == 2 or $offenseId == 5) {
                $id .= $penalty['2nd'];
            } else if ($offenseId == 3) {
                $id .= $penalty['3rd'];
            } else if ($offenseId == 6) {
                $id .= $penalty['6th'];
            }
        } else if ($offense1 == 1 && $offense2 == 1 && $offense3 == 0) {
            if ($offenseId == 2 or $offenseId == 3 or $offenseId == 5) {
                $id .= $penalty['6th'];
            }
        }

        return $id;
    }
}
