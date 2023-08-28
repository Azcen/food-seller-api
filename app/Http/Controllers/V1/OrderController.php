<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/orders",
     *     operationId="getOrders",
     *     tags={"Orders"},
     *     summary="Get a list of orders",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/OrderResponseSchema"))
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $orders = $this->orderService->handleGetOrders();
        return response()->json($orders);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/orders",
     *     operationId="createOrder",
     *     tags={"Orders"},
     *     summary="Create a new order",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OrderRequestSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/OrderResponseSchema")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity. Validation errors.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $order = $this->orderService->handleCreateOrder($data);
        return response()->json($order, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/orders/{id}",
     *     operationId="getOrder",
     *     tags={"Orders"},
     *     summary="Get details of a specific order",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the order"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/OrderResponseSchema")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order not found."),
     *             @OA\Property(property="status_code", type="integer", example=404),
     *             @OA\Property(property="error_type", type="string", example="Not Found"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function find($id)
    {
        $order = $this->orderService->handleGetOrder($id);
        return response()->json($order);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/orders/{id}",
     *     operationId="updateOrder",
     *     tags={"Orders"},
     *     summary="Update the status of a specific order",
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Bearer token"
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="ID of the order"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", example="Active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/OrderResponseSchema")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order not found."),
     *             @OA\Property(property="status_code", type="integer", example=404),
     *             @OA\Property(property="error_type", type="string", example="Not Found"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity. Validation errors.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function update(OrderRequest $request, string $id)
    {
        $data = $request->validated();
        $order = $this->orderService->handleUpdateOrder($id, $data);

        return response()->json($order);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/orders/{id}",
     *     operationId="deleteOrder",
     *     tags={"Orders"},
     *     summary="Delete a specific order",
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Bearer token"
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="ID of the order"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order deleted"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Token missing or invalid.",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Order not found."),
     *             @OA\Property(property="status_code", type="integer", example=404),
     *             @OA\Property(property="error_type", type="string", example="Not Found"),
     *         ),
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy(string $id)
    {
        $this->orderService->handleDestroyOrder($id);

        return response()->json(['message' => 'Order deleted']);
    }
}
