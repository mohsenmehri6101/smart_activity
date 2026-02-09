<?php

/**
 * @OA\Info(
 *     title="Activity API",
 *     version="1.0.0",
 *     description="API documentation for Activity endpoints"
 * )
 * @OA\Tag(
 *     name="Activity",
 *     description="Endpoints for managing activities"
 * )
 */

/**
 * @OA\Get(
 *     path="/api/activities",
 *     summary="Get a list of activities",
 *     tags={"Activity"},
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         description="Filter by activity type",
 *         required=false,
 *         @OA\Schema(type="string", enum={"task_created","comment_added"})
 *     ),
 *     @OA\Parameter(
 *         name="actor",
 *         in="query",
 *         description="Filter by actor",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="from",
 *         in="query",
 *         description="Start date for filtering activities",
 *         required=false,
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Parameter(
 *         name="to",
 *         in="query",
 *         description="End date for filtering activities",
 *         required=false,
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Activities retrieved successfully"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error retrieving activities"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/activities/{id}",
 *     summary="Get a single activity by ID",
 *     tags={"Activity"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the activity",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Activity retrieved successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Activity not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error retrieving activity"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/activities",
 *     summary="Create a new activity",
 *     tags={"Activity"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="type", type="string", description="Activity type: task_created or comment_added"),
 *                 @OA\Property(property="actor", type="string", description="Actor performing the activity"),
 *                 @OA\Property(property="target", type="string", description="Target of the activity"),
 *                 @OA\Property(property="timestamp", type="string", format="date-time", description="Activity timestamp"),
 *                 @OA\Property(property="metadata", type="array", description="Additional metadata", nullable=true, @OA\Items(type="string"))
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Activity created successfully"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error creating activity"
 *     )
 * )
 */

/**
 * @OA\Put(
 *     path="/api/activities/{id}",
 *     summary="Update an existing activity",
 *     tags={"Activity"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the activity",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="type", type="string", description="Activity type: task_created or comment_added"),
 *                 @OA\Property(property="actor", type="string", description="Actor performing the activity"),
 *                 @OA\Property(property="target", type="string", description="Target of the activity"),
 *                 @OA\Property(property="timestamp", type="string", format="date-time", description="Activity timestamp"),
 *                 @OA\Property(property="metadata", type="array", description="Additional metadata", nullable=true, @OA\Items(type="string"))
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Activity updated successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Activity not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error updating activity"
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/activities/{id}",
 *     summary="Delete an activity by ID",
 *     tags={"Activity"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the activity",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Activity deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Activity not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error deleting activity"
 *     )
 * )
 */
