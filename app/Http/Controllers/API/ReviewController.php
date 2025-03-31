<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Repositories\ProductRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewRepository $reviewRepository,
        private ProductRepository $productRepository
    ){}

    public function index(int $product_id) {
        if(!$this->productRepository->isExists($product_id))
            return response()->json([
                'message' => "Product id: {$product_id} does not exist.",
                'errors' => ['product_id' => "Product id: {$product_id} does not exist."]
            ], 404);

        $reviews = $this->reviewRepository->getByProductId($product_id, 20);
        return new ReviewCollection($reviews);
    }

    public function store(CreateReviewRequest $request, int $product_id) {
        $request->validated();

        if (!$this->productRepository->isExists($product_id)) {
            return response()->json([
                'message' => "Product id: {$product_id} does not exist.",
                'errors' => ['product_id' => "Product id: {$product_id} does not exist."]
            ], 404);
        }

        $product = $this->productRepository->getById($product_id);

        $review = $this->reviewRepository->create([
            'customer_id' => $request->input('customer_id'),
            'product_id' => $product_id,
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);

        //TODO - Update Rating Product

        return new ReviewResource($review->refresh());
    }

    public function update(UpdateReviewRequest $request, int $product_id, int $review_id) {
        $validated = $request->validated();

        if (!$this->productRepository->isExists($product_id))
            return response()->json([
                'message' => "Product id: {$product_id} does not exist.",
                'errors' => ['product_id' => "Product id: {$product_id} does not exist."]
            ], 404);

        if(!$this->reviewRepository->isExists($review_id))
            return response()->json([
                'message' => "Review id: {$review_id} does not exist.",
                'errors' => ['review_id' => "Review id: {$review_id} does not exist."]
            ], 404);

        $review = $this->reviewRepository->getById($review_id);

        if ($review->product_id !== $product_id) {
            return response()->json([
                'message' => "Review not found for product id: {$product_id}.",
                'errors' => ['review_id' => "Review id: {$review_id} does not exist."]
            ], 404);
        }

        $customer_id = $request->input('customer_id');

        if ($review->customer_id !== $customer_id) {
            return response()->json([
                'message' => 'Unauthorized action.',
                'errors' => ['customer_id' => 'You can only update your own reviews.']
            ], 403);
        }

        $this->reviewRepository->update( [
            'comment' => $request->input('comment', $review->comment),
            'rating' => $request->input('rating', $review->rating),
        ], $review->id);

        //TODO - Update Rating Product
        return new ReviewResource($review->refresh());
    }

    public function destroy(int $product_id, int $review_id) {
        if (!$this->productRepository->isExists($product_id))
            return response()->json([
                'message' => "Product id: {$product_id} does not exist.",
                'errors' => ['product_id' => "Product id: {$product_id} does not exist."]
            ], 404);

        if(!$this->reviewRepository->isExists($review_id))
            return response()->json([
                'message' => "Review id: {$review_id} does not exist.",
                'errors' => ['review_id' => "Review id: {$review_id} does not exist."]
            ], 404);

        $review = $this->reviewRepository->getById($review_id);

        if ($review->product_id !== $product_id) {
            return response()->json([
                'message' => "Review not found for product id: {$product_id}.",
                'errors' => ['review_id' => "Review id: {$review_id} does not exist."]
            ], 404);
        }

        $this->reviewRepository->delete($review_id);

        return response()->json(['message' => 'Review deleted successfully.'], 200);
    }
}
