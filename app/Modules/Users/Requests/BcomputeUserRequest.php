<?php

namespace App\Modules\Users\Requests;

use App\Base\Request;
use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserPlan;
use Illuminate\Support\Carbon;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class BcomputeUserRequest extends Request
{

  function __construct()
  {
    $this->rules = [];
  }

  /**
   *
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function attributes()
  {
    return [];
  }

  /**
   * Get User Item
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function process()
  {
    // if (date('j') != 1) {
    //   $this->error('We are not the first day of the month!');
    // }
    $nowDate = Carbon::create(null, null, 1, 0, 0, 0);
    $previousMonthDate = $nowDate->copy()->subMonths(1);
    $daysinmonth = $nowDate->diffInDays($previousMonthDate);
    $userPlans = UserPlan::with('plans')->with('users')->where('user_id', '!=', 1)
      ->where('plan_billed', 0)->get();
    $planEndDate = 0;
    $bill = [];

    foreach ($userPlans as $i => $userPlan) {

      if ($userPlan->plan_end_date == 0) {

        $userPlan->plan_end_date = $nowDate->getTimestamp();
        $userPlan->plan_billed = 1;
        $userPlan->save();
      } else {

        $userPlan->plan_billed = 1;
        $userPlan->save();
      }

      $duration = round(($userPlan->plan_end_date - $userPlan->plan_start_date) / 3600 / 24);

      $amount = round($duration * $userPlan->plan_price / $daysinmonth);

      $bill[$i]['plan'] = $userPlan->plan_desc;
      $bill[$i]['duration'] = $duration . ' days';
      $bill[$i]['price'] = $amount . ' euros';
      $bill[$i]['dates'] = [
        'start' => date('Y-m-d', $userPlan->plan_start_date),
        'end' => date('Y-m-d', $userPlan->plan_end_date)
      ];

      if (in_array($userPlan->plans->plan_type, ['memory', 'disk'])) {
        $newUserPlan = new UserPlan();
        $newUserPlan->plan_id = $userPlan->plan_id;
        $newUserPlan->user_id = $userPlan->user_id;
        $newUserPlan->plan_start_date = $nowDate->getTimestamp();
        $newUserPlan->save();
      }
      $mailBody = print_r($bill, true);
      $mail = "<pre>{$mailBody}</pre>";
      mail('m.elkady365@gmail.com', "[BILLING] From {$previousMonthDate} to {$nowDate} - User {$userPlan->users->user_name} ({$userPlan->users->user_id}) ", $mail, "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\n");
    }



    return ['response' => 'OK'];
  }

}
