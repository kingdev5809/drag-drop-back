<?php

namespace App\Http\Controllers;
/**
 * @OA\OpenApi(
 *
 *     @OA\Info(
 *         title="App-Api",
 *         version="1.0.0"
 *     ),
 *
 *     @OA\Components(
 *
 *      @OA\Header(
 *             header="Accept",
 *
 *             @OA\Schema(type="string", default="application/json")
 *         ),
 *
 *      @OA\SecurityScheme(
 *         type="http",
 *         scheme="bearer",
 *         bearerFormat="JWT",
 *         securityScheme="bearerAuth"
 *     ),
 *   ),
 * )
 */
abstract class Controller
{
    //
}
