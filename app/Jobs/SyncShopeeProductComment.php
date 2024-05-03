<?php

namespace App\Jobs;

use App\Http\Services\ShopeeService\ShopeeService;
use App\Models\Review;
use App\Models\ShopeeProduct;
use App\Models\User;
use Haistar\ShopeePhpSdk\client\ShopeeApiConfig;
use Haistar\ShopeePhpSdk\request\shop\ShopApiClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncShopeeProductComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ShopeeService $shopeeService;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private int $cursor = 0, private int $pageSize = 100)
    {
        $this->shopeeService = new ShopeeService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $commentList = $this->shopeeService->getShopeeProductComment($this->cursor, $this->pageSize);
        foreach ($commentList->response->item_comment_list as $comment) {
            $item = ShopeeProduct::where('shopee_product_id', $comment->item_id)->whereNotNull('product_id')->first();
            if($item) {
                Review::firstOrCreate([
                    'shopee_comment_id' => $comment->comment_id
                ],[
                    'buyer_username' => $comment->buyer_username,
                    'details' => $comment->comment,
                    'product_score' => $comment->rating_star,
                    'product_id' => $item->product_id,
                    'reply' => isset($comment->comment_reply) ? $comment->comment_reply->reply : '',
                    'reply_by' => User::first()->id,
                    'shopee_comment_id' => $comment->comment_id
                ]);
            }
        }
        if($commentList->response->more) {
            dispatch(new SyncShopeeProductComment($this->cursor + $this->pageSize));
        }
    }
}
