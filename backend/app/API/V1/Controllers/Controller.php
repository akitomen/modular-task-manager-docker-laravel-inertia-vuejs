<?php

namespace App\API\V1\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Task Manager API Documentation"
 * )
 *
 * @OA\Server( url=L5_SWAGGER_CONST_HOST )
 *
 * @OA\SecurityScheme(
 *       scheme="Bearer",
 *       securityScheme="Bearer",
 *       type="apiKey",
 *       in="header",
 *       name="Authorization",
 * )
 *
 * @OA\Tag( name="Authentication", description="" )
 *
 * @OA\Response(response="Unauthorized", description="If no token...")
 *
 */

class Controller extends \App\Http\Controllers\Controller
{
}
