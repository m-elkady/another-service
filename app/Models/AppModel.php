<?php

namespace App\Models;

use App\Base\Request;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model {

  public $timestamps       = false;
  public $filterAttributes = [];

  public function scopePagination($query, Request $request) {
    $perPage = $request->perPage ? intval($request->perPage) : $this->perPage;
    $orderBy = $request->orderBy ? $request->orderBy : $this->orderBy;
    $order   = $request->order ? $request->order : $this->order;
    $from    = $request->from;
    $to      = $request->to;
    $this->setPerPage($perPage);

    $attributes = empty($this->getAttributes()) ? $request->modelAttributes : $this->getAttributes();
    foreach ($attributes as $attribute) {
      if ($request->{$attribute}) {
        if (isset($this->filterAttributes[$attribute])) {
          $condition = $this->filterAttributes[$attribute];
          $value     = $condition == 'like' ? "%{$request->{$attribute}}%" : $request->{$attribute};
          $query->where($attribute, $condition, $value);
        } else {
          $query->where($attribute, $request->{$attribute});
        }
      }
    }

    if ($from) {
      $query->where('user_date', '>=', $from);
    }
    if ($to) {
      $query->where('user_date', '<=', $value);
    }


    $query->orderBy($orderBy, $order);
    return $query->paginate()->appends($request->getAttributes());
  }

}
