<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'      => $this->id,
            'message' => $this->message
        ];
    }

    public function with($request) {

        return [
            'version' => '1.0.0',
            'author'  => 'Codrut',
            'email'   => 'codrut@web3box.com'
        ];
    }
}
