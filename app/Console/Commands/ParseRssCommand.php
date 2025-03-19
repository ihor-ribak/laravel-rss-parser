<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RssParser;
use Psr\Log\LoggerInterface;

class ParseRssCommand extends Command
{
    protected $signature = 'rss:parse';
    protected $description = 'Fetch and parse RSS feeds';

    private RssParser $rssParser;
    private LoggerInterface $logger;

    public function __construct(RssParser $rssParser, LoggerInterface $logger)
    {
        parent::__construct();
        $this->rssParser = $rssParser;
        $this->logger = $logger;
    }

    public function handle(): void
    {
        $this->info('Starting RSS parsing...');

        try {
            $rssUrl = config('services.rss.life_hacker_rss_url');
            $this->rssParser->parse($rssUrl);

            $this->info('RSS parsing completed.');
        } catch (\Exception $e) {
            $this->error('Error during parsing: ' . $e->getMessage());
            $this->logger->error('RSS Parsing failed', ['exception' => $e]);
        }
    }
}
