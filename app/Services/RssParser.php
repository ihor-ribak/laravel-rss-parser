<?php

namespace App\Services;

use App\Repositories\PostRepository;
use SimpleXmlElement;

class RssParser
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @throws \Exception
     */
    public function parse(string $rssUrl): void
    {
        $rss = simplexml_load_file($rssUrl);
        if (!$rss) {
            throw new \Exception('Failed to load RSS feed.');
        }

        foreach ($rss->channel->item as $item) {
            $guid = (string)$item->guid;
            $title = (string)$item->title;
            $link = (string)$item->link;
            $description = (string)$item->description;
            $pubDate = strtotime((string)$item->pubDate);

            $this->postRepository->updateOrCreatePost($guid, [
                'title' => $title,
                'link' => $link,
                'description' => $description,
                'pub_date' => $pubDate,
            ]);
        }
    }
}
