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
}
