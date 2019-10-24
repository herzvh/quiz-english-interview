<?php
class Day extends Model {
    /**
     * Get day between two dates and by user id
     */
    public function getDayBetweenToDate($min, $max, $userId)
    {
        return $this->where('date', '>=', $min)
            ->where('date', '<=', $max)
            ->where('user_id', $userId)
            ->orderBy('date', 'ASC')
            ->get();
    }
}