<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class ApiController extends Controller
{
  protected function respondWithData($data, $status = 200)
  {
      return response()->json([
          'data' => $data
      ], $status);
  }

  protected function respondWithError($status, $message = '', $errors = '', $meta = '')
  {
      $data = [];

      if (!$message) {
          $message = Response::$statusTexts[$status];
      }

      $data['message'] = $message;

      if ($errors) {
          $data['errors'] = $errors;
      }

      if ($meta) {
          $data['meta'] = $meta;
      }

      return response()->json($data, $status);
  }

  public function respondWithErrorWrongArguments($errors, $meta = '')
  {
      return $this->respondWithError(Response::HTTP_UNPROCESSABLE_ENTITY, Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY], $errors, $meta);
  }
}
