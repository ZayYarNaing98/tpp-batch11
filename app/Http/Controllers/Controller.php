<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'TPP API',
    description: 'API documentation for the TPP application.',
    contact: new OA\Contact(name: 'API Support', email: 'zayarnaing.pp@gmail.com')
)]
#[OA\Server(
    url: L5_SWAGGER_CONST_HOST,
    description: 'API Server'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Enter the JWT token returned from the login endpoint.'
)]
#[OA\Tag(name: 'Auth', description: 'Authentication endpoints')]
#[OA\Tag(name: 'Categories', description: 'Category management')]
#[OA\Tag(name: 'Batches', description: 'Batch management')]
#[OA\Tag(name: 'Instructors', description: 'Instructor management')]
#[OA\Tag(name: 'Students', description: 'Student management')]
#[OA\Tag(name: 'Users', description: 'User management')]
#[OA\Tag(name: 'Roles', description: 'Role management')]
#[OA\Tag(name: 'Permissions', description: 'Permission management')]
abstract class Controller
{
    //
}
