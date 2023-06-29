<?php

namespace app\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    private function jsonResponse($data, $code = 200): JsonResponse
    {
        return response()->json($data, $code);
    }

    protected function response($message, $data = null, $meta = null, $code = Response::HTTP_OK): JsonResponse
    {
        $response = ['message' => $message, 'status_code' => $code];

        if ($meta) {
            $response = array_merge(['meta' => $meta], $response);
        }

        if (null !== $data) {
            $response = array_merge(['data' => $data], $response);
        }

        return $this->jsonResponse($response, $code);
    }

    protected function responseMessage($message, $code = Response::HTTP_OK): JsonResponse
    {
        return $this->response($message, null, null, $code);
    }

    protected function showOne($instance, $resource, $message = 'success', $code = 200): JsonResponse
    {
        return $this->response($message, new $resource($instance));
    }

    protected function showAll($data, $resource, $pagination, $message = 'success', $code = 200): JsonResponse
    {
        $response = $resource::collection($data);

        return $this->response($message, $response, ['pagination' => $pagination], $code);
    }

    protected function getPaginationMeta(LengthAwarePaginator $paginator): array
    {
        return [
            'total'        => $paginator->total(),
            'per_page'     => $paginator->perPage(),
            'count'        => count($paginator->items()),
            'current_page' => $paginator->currentPage(),
        ];
    }
}
