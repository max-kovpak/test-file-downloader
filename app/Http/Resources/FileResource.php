<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'url'          => $this->url,
            'status'       => $this->status,
            'real_name'    => $this->real_name,
            'mime_type'    => $this->mime_type,
            'size'         => $this->size,
            'ext'          => $this->ext,
            'download_url' => $this->download_url,
            'created_at'   => $this->created_at->format(\DateTime::ISO8601),
            'updated_at'   => $this->created_at->format(\DateTime::ISO8601),
        ];
    }
}
