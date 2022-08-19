<?php

namespace Http\Resources;

class TaskCollectionResource extends BasicResource
{
    public function __construct($resource)
    {
        parent::__construct($resource, true);

        $this->data = [
            'items' => $this['data']->transform(function ($task) {

                $labels = new LabelCollectionResource(['data' => $task->labels]);

                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'labels' => $labels['data']['items']->toArray(),
                ];
            }),
            'count' => $this->count,
        ];
    }
}
