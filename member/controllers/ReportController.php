<?php

namespace member\controllers;

use Yii;
use common\models\Task;
use common\models\Employee;

class ReportController extends ApiController {

    /**
     * Get task report
     */
    public function actionGetTaskReport($projectId = 0) {
        return $this->sendResponse(false, '', Task::getTaskReportByProjectId($projectId));
    }
    
    /**
     * Get employee task report
     */
    public function actionGetEmployeeTaskReport($projectId = 0) {
        $result = [];
        $employee = new Employee();
        if ($reports = Task::getEmployeeTaskReportByProjectId($projectId)) {
            foreach ($reports as $report) {
                $employee->company_id = $report['company_id'];
                $employee->firstname = $report['firstname'];
                $employee->lastname = $report['lastname'];
                $employee->profile_image_path = $report['profile_image_path'];
                $result[] = [
                    'employee_fullname' => $employee->fullname,
                    'avatar' => $employee->image,
                    'total_hour' => $report['total_hour'],
                ];
            }
        }

        return $this->sendResponse(false, '', $result);
    }
    
}
