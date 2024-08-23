<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title'   => 'Love languages',
                'sub_title' => 'Words of Affirmation,Quality Time,Acts of Service,Physical Touch,Receiving Gifts'
            ],
            [
                'title'   => 'Self Care',
                'sub_title' => 'Therapy,Sleeping well,Deep chats,Time offline,Nutrition,Mindfulness'
            ],
            [
                'title'   => 'Sports',
                'sub_title' => 'Running,Yoga,Badminton,Gym,Cricket,Soccer,Tennis,Swimming,Golf,Walking'
            ],
            [
                'title'   => 'Creativity',
                'sub_title' => 'Art,Design,Make-up,Writing,Photography,Crafts,Making videos,Singing,Dancing'
            ],
            [
                'title'   => 'Going Out',
                'sub_title' => 'Concerts,Museums & galleries,Theatre,Festivals,Stand up,Bars,Clubs,Karaoke'
            ],
            [
                'title'   => 'Staying In',
                'sub_title' => 'Video games,Board games,Gardening,Cooking,Baking'
            ],
            [
                'title'   => 'Film & TV',
                'sub_title' => 'Romance,Comedy,Drama,Horror,Thriller,Fantasy,Sci-fi,Anime'
            ],
            [
                'title'   => 'Reading',
                'sub_title' => 'Romance,Comedy,Horror,Mystery,Thriller,Fantasy,Sci-fi,Manga'
            ],
            [
                'title'   => 'Music',
                'sub_title' => 'Pop,Rock,Hip-hop/Soul,R&B/Soul,Jazz,Country,Electronic/Dance,Alternative/Indie,Latin,Classical'
            ],
            [
                'title'   => 'Food & Drink',
                'sub_title' => 'Vegetarian,Paleo,Vegan,Pescatarian,Keto,Omnivore,Carnivore,Halal,Gluten-free,Dairy-free,Kosher,Organic'
            ],
             [
                'title'   => 'Traveling',
                'sub_title' => 'Beaches,Spa weekends,Fishing,Camping,Road trips,Winter sports,Staycations,Backpacking,Hiking trips,Exploring new,cities'
            ],
            [
                'title'   => 'Pets',
                'sub_title' => 'Dogs,Cats,Birds,Fish,Other'
            ]
        ];
        foreach ($data as $datum) {
            Interest::create($datum);
        }
    }
}
