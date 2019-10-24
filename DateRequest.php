<?php 
/**
 * Date validator class extracted from existing controller class
 */
class DateRequest extends Request {
    public function rules() {
        return [
          'startDate' => 'date_format:Y-m-d',
          'endDate' => 'date_format:Y-m-d',
        ];
    }
}