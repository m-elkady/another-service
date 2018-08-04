<?php

namespace App\Models;

use App\Base\Request;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
  public $timestamps = false;


  public function scopePagination($query, Request $request)
  {
    $perPage = $request->perPage ? intval($request->perPage) : $this->perPage;
    $orderBy = $request->orderBy ? $request->orderBy : $this->orderBy;
    $order = $request->order ? $request->order : $this->order;
    $this->setPerPage($perPage);

    $attributes = $this->getAttributes();
    foreach ($attributes as $attribute) {
      if ($request->{$attribute}) {
        $query->where($attribute, $request->{$attribute});
      }
    }

    $query->orderBy($orderBy, $order);
    return $query->paginate()->appends($request->getAttributes());
  }

}