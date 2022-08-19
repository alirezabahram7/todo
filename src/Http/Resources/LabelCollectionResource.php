<?php

namespace Http\Resources;

use Illuminate\Support\Facades\Auth;
use function auth;

class LabelCollectionResource extends BasicResource
{
    public function __construct($resource)
    {
        parent::__construct($resource, true);

        $this->data = [
            'items' => $this['data']->transform(function ($label) {
                $tasksCount = auth()->check() ? Auth::user()->tasks()->wherehas('labels',function ($q) use($label){
                    $q->where('label_id',$label->id);
                })->count() : 0;

                return [
                    'id' => $label->id,
                    'label' => $label->name,
                    'tasks_count' => $tasksCount
                ];
            }),
            'count' => $this->count,
        ];
    }
}
