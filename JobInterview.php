  public function getDayRange2(
      $startDate,
      $endDate
  ) {
      $validator = Validator::make(['startDate' => $startDate, 'endDate' => $endDate], [
          'startDate' => 'date_format:Y-m-d',
          'endDate' => 'date_format:Y-m-d',
      ]);

      if ($validator->fails()) {
          return response()->json($validator->getErrors(), 422);
      }

      $user = auth()->user();

      $startDate = new Carbon($startDate);
      $endDate = new Carbon($endDate);

      $min = $startDate->format('Y-m-d');
      $max = $endDate->format('Y-m-d');

      $days = Day::where('date', '>=', $min)
          ->where('date', '<=', $max)
          ->where('user_id', $user->id)
          ->orderBy('date', 'ASC')
          ->get();

      foreach ($days as &$day) {
          $day->meals = Meal::where('day_id', $day->id)->get();
      }

      $max = $endDate->toImmutable();
      $min = $startDate->toImmutable();

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
              'calorie_limit' => 1500,
              'total_calories' => 0,
              'meals' => []
          ];

          $min = $min->add('day', 1);
      }

      return response()->json($transformedDays);
  }