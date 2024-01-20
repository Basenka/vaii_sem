<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\JsonResponse;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShoppingCart;
use App\Models\User;
use Exception;

class OrderItemController extends AControllerBase
{
    public function index(): Response
    {
    }


    public function save()
    {
        try {
            // ziskanie dat z requestu ako asociativne pole
            $data = json_decode(file_get_contents('php://input'), true);

            $productItems = $data['productItems'];
            $orderId = $data['orderId'];

            // Iteracia nad vsetkymi produktami z kosika a ich ulozenie ako polozky objedanvky
            foreach ($productItems as $productItem) {
                $productId = $productItem['productId'];
                $quantity = $productItem['quantity'];
                $price = $productItem['price'];

                $orderItem = new OrderItem();
                $orderItem->setProductId($productId);
                $orderItem->setQuantity($quantity);
                $orderItem->setUnitPrice($price);
                $orderItem->setOrderId($orderId);
                $orderItem->save();

                //po vlozeni produktu do objednavky ho vymazeme z kosika
                $cartItem = ShoppingCart::getOne($productItem['itemId']);
                $cartItem->delete();
            }

            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }
    }

}