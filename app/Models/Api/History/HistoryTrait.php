<?php

namespace App\Models\Api\History;

use ContragentRevision;

/**
 * Description of HistoryTrait
 *
 * @author PACO
 */
trait HistoryTrait {

    /**
     * Automatically boot with Model, and register Events handler.
     */
    public static function bootHistoryTrait() {
//        parent::boot();

        foreach (static::getRecordActivityEvents() as $eventName) {
            static::$eventName(function ($model) use ($eventName) {
                try {
                    $modelRevisionObj = self::getRevisionObject($model);
                    
                    $diff = static::getDiff($model);

                    if (!$diff['before'] && !$diff['after']) {
                        return true;
                    }

                    $relations = $model->getRelations();
                    
                    foreach ($diff['before'] as $key => $value) {

                        if (static::isRelated($key)) {
                            $relatedModel = static::getRelatedModel($model, $key);
                            
                            //check related model need to be logged
                            if(!$relatedModel)
                                continue;
                            
                            //load related model and get old value
                            $relatedModelObj = new $relatedModel;
                            $relModel = $relatedModelObj::find($value);

                            $relations = static::getRelatedModelRelations($model, $key);

                            $modelBefore = $relModel->load($relations);

                            //get new value
                            $relModel = $relatedModelObj::find($diff['after'][$key]);
                            $modelAfter = $relModel->load($relations);

                            $accessColumnValue = static::getRelatedModelColumn($model, $key);

                            $row['old_value'] = array_get($modelBefore->toArray(), $accessColumnValue);
                            $row['new_value'] = array_get($modelAfter->toArray(), $accessColumnValue);
                        } else {
                            $row['old_value'] = $value;
                            $row['new_value'] = $diff['after'][$key];
                        }

                        $mutator = 'get' . studly_case($key) . 'Attribute';
                        
                        if (method_exists($model, $mutator)) {
                            $key = $model->$mutator($key);
                        }
                        
                        $row['column'] = $key;

                        $foreign_key = $model->foreign_key;
//                    
//                    //set history relation col to appropriate value
                        $row['revisionable_id'] = $model->$foreign_key;
                        $row['user_id'] = \Auth::user()->id;

                        $modelRevisionObj::create($row);
                    }
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            });
            
            return true;
        }
    }

    /**
     * Check if given column is relation or not regardles to laraver convention naming
     * @param type $column
     * @return boolean
     */
    private static function isRelated($column) {
        $isRelated = false;
        $idSuffix = '_id';
        $pos = strrpos($column, $idSuffix);
        if ($pos !== false && strlen($column) - strlen($idSuffix) === $pos
        ) {
            $isRelated = true;
        }
        return $isRelated;
    }

    /**
     * Return the name of the related model.
     *
     * @return string
     */
    private static function getRelatedModel($model, $relationColumn) {
        return $model->foreign_keys[$relationColumn]['classname'];
    }

    private static function getRelatedModelRelations($model, $relationColumn) {
        return $model->foreign_keys[$relationColumn]['relations'];
    }

    private static function getRelatedModelColumn($model, $relationColumn) {
        return $model->foreign_keys[$relationColumn]['accessLogColumn'];
    }

    /**
     * Calculate diff between model and changed
     * @param type $model
     * @return type
     */
    protected static function getDiff($model) {
        $changed = $model->getDirty();

        $before = array_intersect_key($model->fresh()->toArray(), $changed);
        $after = $changed;

        return compact('before', 'after');
    }
    
    /**
     * Create new object for model Revision
     * @param type $model
     * @return \App\Models\Api\History\modelRevision
     */
    private static function getRevisionObject($model) {
        $reflect = new \ReflectionClass($model);
        $modelRevision = $reflect->getShortName() . 'Revision';
        return new $modelRevision;
    }

    /**
     * Set the default events to be recorded if the $recordEvents
     * property does not exist on the model.
     *
     * @return array
     */
    protected static function getRecordActivityEvents() {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }

        //events by default if recordEvents is not set
        return [
            'updating',
//            'deleted',
        ];
    }

    /**
     * Return Suitable action name for Supplied Event
     *
     * @param $event
     * @return string
     */
    protected static function getActionName($event) {
        switch (strtolower($event)) {
            case 'created':
            case 'creating':
                return 'create';
            case 'updated':
            case 'updating':
                return 'update';
            case 'deleted':
            case 'deleting':
                return 'delete';
            case 'saved':
            case 'saving':
                return 'save';
            default:
                return 'unknown';
        }
    }

}
