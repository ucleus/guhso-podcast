<?php
// app/Jobs/FetchRssFeed.php

namespace App\Jobs;

use App\Models\Show;
use App\Models\Episode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use willvincent\Feeds\Facades\FeedsFacade as Feeds;
use Carbon\Carbon;

class FetchRssFeed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $show;

    public function __construct(Show $show)
    {
        $this->show = $show;
    }

    public function handle(): void
    {
        try {
            if (!$this->show->rss_feed_url) {
                Log::warning("Show {$this->show->id} has no RSS feed URL");
                return;
            }

            $feed = Feeds::make($this->show->rss_feed_url);
            
            if (!$feed) {
                Log::error("Failed to fetch RSS feed for show {$this->show->id}");
                return;
            }

            // Update show metadata from feed
            $this->show->update([
                'title' => $feed->get_title() ?: $this->show->title,
                'description' => $feed->get_description() ?: $this->show->description,
                'cover_image_url' => $feed->get_image_url() ?: $this->show->cover_image_url,
                'last_fetched_at' => now(),
            ]);

            // Process feed items (episodes)
            $items = $feed->get_items();
            
            foreach ($items as $item) {
                $this->processEpisode($item);
            }

            Log::info("Successfully processed RSS feed for show {$this->show->id}");

        } catch (\Exception $e) {
            Log::error("Error fetching RSS feed for show {$this->show->id}: " . $e->getMessage());
            throw $e;
        }
    }

    private function processEpisode($item)
    {
        $guid = $item->get_id();
        
        // Skip if episode already exists
        if (Episode::where('guid', $guid)->exists()) {
            return;
        }

        $enclosure = $item->get_enclosure();
        if (!$enclosure) {
            return; // Skip items without audio
        }

        $publishedAt = $item->get_date() ? Carbon::parse($item->get_date()) : now();

        Episode::create([
            'show_id' => $this->show->id,
            'title' => $item->get_title(),
            'description' => $item->get_description(),
            'audio_url' => $enclosure->get_link(),
            'duration' => $enclosure->get_duration(),
            'published_at' => $publishedAt,
            'guid' => $guid,
            'file_size' => $enclosure->get_length(),
            'mime_type' => $enclosure->get_type() ?: 'audio/mpeg',
            'is_manual' => false,
            'is_published' => true,
        ]);
    }
}