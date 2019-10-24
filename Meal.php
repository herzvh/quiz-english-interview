<?php
class Meal extends Model {
    public function getMealByDateAndUserId($dayId, $mealId) {
        return $this->where('day_id', $dayId)->where('user_id', $userId)->get();
    }
}