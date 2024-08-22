<?php

namespace App\Models\Traits;


trait CRUD
{
    public static function initializer()
    {
        $request = request();
        $sortBy = $request->get('sortBy');
        $desc = $request->get('descending');

        $query = $request->get('query');
        $filters = json_decode($request->get('filters'));

//        replacing this logic with global scopes
//        if (method_exists(static::class, 'initializeModel')) {
//            $model = static::initializeModel();
//        } else {
//            $model = static::where('id', '>', 0);
//        }
        $model = static::where('id', '>', 0);
        if ($query) {
            $model = $model->queryfilter($query);
        }
        foreach (collect($filters) as $filter => $value) {
            if ($value !== null) {
                if (method_exists(static::class, 'scope' . ucfirst($filter))) {
                    $model->{$filter}($value);
                }
            }
        }
        if ($sortBy == 'null' || !isset($sortBy)) {
            if (method_exists(static::class, 'sortByDefaults')) {
                $sortByDefaults = static::sortByDefaults();
                $sortBy = $sortByDefaults['sortBy'];
                $desc = $sortByDefaults['sortByDesc'];
            } else {
                $sortBy = 'id';
                $desc = true;
            }
        }
        if ($desc == 'true') {
            $model->orderBy($sortBy, 'DESC');
        } else {
            $model->orderBy($sortBy, 'ASC');
        }
        return $model;
    }
}
