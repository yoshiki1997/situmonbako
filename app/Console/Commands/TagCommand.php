<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tag;

class TagCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tag:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get tags from TeratailAPI and store them in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://teratail.com/api/v1/tags?limit=100&page=';

        try{

            for($c = 1;$c<=18;$c++){
                $response = $client->request(
                    'GET',
                    $url . $c,
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . config('services.teratail.token')
                        ]
                    ]
                );

                $tags = json_decode($response->getBody(),true);

                foreach($tags['tags'] as $tag){
                    Tag::updateOrCreate(
                        ['tag_name' => $tag['tag_name']],
                        [
                            'explain' => $tag['explain'],
                            'created_at' => $tag['created'],
                        ]
                    );
                     // タグ名の表示
                echo $tag['tag_name'] . "\n";
                }
            }
            
            $this->info('Tag data has been saved successfully!');
        } catch (GuzzleException $e) {
            $this->info('SOPT ERROE!');
        }
    }
}
