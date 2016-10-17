<?php

namespace Tests\Fixtures\Transformer;

use Tests\Fixtures\Model\Comment;

class CommentTransformer
{
    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id(),
            'message' => $comment->message(),
            'created_at' => $comment->addedAt()->format(\DateTime::ATOM)
        ];
    }
}
