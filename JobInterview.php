<?php
class DayController extends Controller {

    protected $dayModel;
    protected $mealModel;

    public function __constructor(Day $day, Meal $meal) {
        $this->dayModel = $day;
        $this->mealModel = $meal;
    }

    public function getDayRange2(DateRequest $request) {
        /**
         * If request validation fails, in the case of an AJAX request, a JSON response will be returned automatically.
         */
        $min = $this->formatDate($request->get('startDate'));
        $max = $this->formatDate($request->get('endDate'));

        $user = $this->getAuthenticatedUser();

        $days = $this->dayModel->getDayBetweenToDate($min, $max, $user->id);

        foreach ($days as &$day) {
            $day->meals = $this->mealModel->getMealByDateAndUserId($day->id, $user->id);
        }

        $max = $endDate->toImmutable();
        $min = $startDate->toImmutable();

        $transformedDays = $this->transformDate($min, $max, $days);

        return response()->json($transformedDays);
    }

    private function transformDate($min, $max, $days)
    {   
        $CALORY_LIMIT = 1500;
        $transformedDays = [];  
        while ($min <= $max) {
            foreach ($days as $day) {
                if ($day->date === $min->format('Y-m-d')) {
                    $transformedDays[] = $day->toArray();
                    $min = $min->add('day', 1);
                    continue;
                }
            }

            $transformedDays[] = [
                'date'          => $min->format('Y-m-d'),
                'calorie_limit' => $CALORY_LIMIT,
                'total_calories' => 0,
                'meals' => []
            ];

            $min = $min->add('day', 1);
        }

        return $transformedDays;
    }

    private function getAuthenticatedUser() {
        return auth()->user();
    }

    private function formatDate($date)
    {
        $carbonDate = new Carbon($date);
        return $carbonDate->format('Y-m-d');
    }
}